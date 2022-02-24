# PhoenixElasticsearchBundle

- [Core library](#core-library)
- [Manual installation](#manual-installation)
- [Usage](#usage)
- [Commands](#commands)
- [Todo](#todo)
- [Roadmap](#roadmap)
- [Brainstroming](#brainstroming)

## Core library

- https://packagist.org/packages/elasticsearch/elasticsearch
- https://packagist.org/packages/ongr/elasticsearch-dsl

## Manual installation

- Clone repository.

```sh
# https://gitlab.com/phoenix-code-labs/phoenix/phoenix-elasticsearch-bundle
git clone https://gitlab.com/phoenix-code-labs/phoenix/phoenix-elasticsearch-bundle.git
```

- Install dependancies.

```sh
# https://packagist.org/packages/elasticsearch/elasticsearch
composer require elasticsearch/elasticsearch

# https://packagist.org/packages/ongr/elasticsearch-dsl
composer require ongr/elasticsearch-dsl
```
- Autoload bundle with composer.json.

```php
// composer.json
"autoload": {
    "psr-4": {
        "App\\": "src/",

        "Phoenix\\ElasticsearchBundle\\": "vendor/phoenix/elasticsearch-bundle/"
    }
},
```

- Add new bundle in config/bundles.php.

```php
// config/bundles.php
return [
    Phoenix\ElasticsearchBundle\PhoenixElasticsearchBundle::class => ['all' => true],
]
```
## Usage

### Create index class and register it as service with 'es.index' tag:

```php
// vendor/phoenix/api-bundle/Elasticsearch/Index/LocationIndex.php

<?php
/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phoenix\ApiBundle\Elasticsearch\Index;

use Phoenix\ElasticsearchBundle\Index\AbstractIndex;
use Phoenix\ApiBundle\Elasticsearch\Document\LocationDocument;

/**
 * Class LocationIndex
 *
 * @package Phoenix\ApiBundle\Index
 * @author Hiren Chhatbar
 */
class LocationIndex extends AbstractIndex
{
    /**
     * Holds name.
     *
     * @var string
     */
    public string $name = 'location';

    /**
     * Constructor.
     *
     * @param LocationDocument $document
     */
    public function __construct(LocationDocument $document)
    {
        $this->document = $document;
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\ElasticsearchBundle\Index\AbstractIndex::settings()
     */
    public function settings(): array
    {
        $settings = $this->defaultSettings();

        return $settings;
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\ElasticsearchBundle\Index\AbstractIndex::mappings()
     */
    public function mappings(): array
    {
        $defaultMappings = $this->defaultMappings();

        $mappings = [
            'properties' => [
                'parent' => [
                    'type' => 'integer',
                ],
                'name' => [
                    'type' => 'keyword',
                ],
                'path' => [
                    'type' => 'keyword',
                ],
                'level' => [
                    'type' => 'integer',
                ],
                'latitude' => [
                    'type' => 'float',
                ],
                'longitude' => [
                    'type' => 'float',
                ],
                'slug' => [
                    'type' => 'text',
                ],
                'uuid' => [
                    'type' => 'text',
                ],
                'lat_long' => [
                    'type' => 'geo_point',
                ],
            ]
        ];

        return \array_merge_recursive($defaultMappings, $mappings, $this->translationMapping());
    }
}
```

```yaml
# vendor/phoenix/api-bundle/Resources/config/services_elasticsearch.yaml

Phoenix\ApiBundle\Elasticsearch\Index\LocationIndex:
    arguments: ['@Phoenix\ApiBundle\Elasticsearch\Document\LocationDocument']
    tags: ['es.index']
    calls:
        - [setPrefix, ['%pes.index_prefix%']]
```

### Create document class and register it as service with 'es.document' tag:

```php
// vendor/phoenix/api-bundle/Elasticsearch/Document/LocationDocument.php

<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phoenix\ApiBundle\Elasticsearch\Document;

use Phoenix\ElasticsearchBundle\Document\AbstractDocument;
use Doctrine\ORM\QueryBuilder;
use Phoenix\QueryBundle\Service\QueryService;
use App\Entity\Location;
use Phoenix\ApiBundle\EntityService\LocationService;

/**
 * Class LocationDocument
 *
 * @package Phoenix\ApiBundle\Document
 * @author Hiren Chhatbar
 */
class LocationDocument extends AbstractDocument
{
    /**
     * Holds object of QueryService.
     *
     * @var QueryService
     */
    protected QueryService $queryService;

    /**
     * Holds object of LocationService.
     *
     * @var LocationService
     */
    protected LocationService $locationService;

    /**
     * Constructor.
     *
     * @param QueryService $queryService
     * @param LocationService $locationService
     */
    public function __construct(QueryService $queryService, LocationService $locationService)
    {
        $this->queryService = $queryService;

        $this->locationService = $locationService;
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\ElasticsearchBundle\Document\DocumentInterface::get()
     */
    public function get(int $id): array
    {
        $res = $this->queryService->select('location__find_one', ['id' => $id]);

        $row = \reset($res['rows']);

        if ($row['latitude'] && $row['longitude']) {
            $row['lat_long'] = sprintf('%s,%s', $row['latitude'], $row['longitude']);
        }

        $resTrans = $this->queryService->select('location_translation__find_by_object', ['object' => $id]);

        foreach ($resTrans['rows'] as $rowTrans) {
            unset($rowTrans['id']);

            $row['translation'][] = $rowTrans;

            $fullnameTrans = [
                'locale' => $rowTrans['locale'],
                'field' => 'fullname',
                'content' => $this->locationService->hierarchyAsString($row['id'], $rowTrans['locale']),
            ];

            $row['translation'][] = $fullnameTrans;
        }

        $row['parent'] = $row['parent_id'];

        unset($row['parent_id']);

        return $row;
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\ElasticsearchBundle\Document\DocumentInterface::queryBuilder()
     */
    public function queryBuilder(): QueryBuilder
    {
        $qb = $this->queryService->repository(Location::class)->createQueryBuilder('l');

        $qb->select('l.id');

        return $qb;
    }
}
```

```yaml
# vendor/phoenix/api-bundle/Resources/config/services_elasticsearch.yaml

Phoenix\ApiBundle\Elasticsearch\Document\LocationDocument:
    arguments: ['@Phoenix\QueryBundle\Service\QueryService', '@Phoenix\ApiBundle\EntityService\LocationService']
    tags: ['es.document']
```

### Use DI (Dependancy Injection) and use Phoenix\ElasticsearchBundle\Service and its search method to execute search query:

```php
// vendor/phoenix/api-bundle/CrudManipulator/LocationAdminCrudManipulator.php

<?php
/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\ApiBundle\CrudManipulator;

use ONGR\ElasticsearchDSL\Search;
use Phoenix\ElasticsearchBundle\Service\DocumentService;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use Phoenix\ApiBundle\Elasticsearch\Index\LocationIndex;
use Phoenix\ElasticsearchBundle\Utils\Pagination;
use ONGR\ElasticsearchDSL\Sort\FieldSort;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\WildcardQuery;
use Phoenix\ElasticsearchBundle\Utils\Util;

/**
 * Class LocationCrudManipulator
 *
 * @package Phoenix\ApiBundle\CrudManipulator
 * @author Hiren Chhatbar
 */
class LocationAdminCrudManipulator extends AbstractCrudManipulator
{
    /**
     * Holds object of LocationIndex.
     *
     * @var LocationIndex
     */
    protected LocationIndex $locationIndex;

    /**
     * Holds object of DocumentService.
     *
     * @var DocumentService
     */
    protected DocumentService $documentService;

    /**
     * Holds object of Pagination.
     *
     * @var Pagination
     */
    protected Pagination $pagination;

    /**
     * Holds object of Util.
     *
     * @var Util
     */
    protected Util $util;

    /**
     * Constructor.
     *
     * @param LocationIndex $locationIndex
     * @param DocumentService $documentService
     * @param Pagination $pagination
     */
    public function __construct(LocationIndex $locationIndex, DocumentService $documentService, Pagination $pagination, Util $util)
    {
        $this->locationIndex = $locationIndex;

        $this->documentService = $documentService;

        $this->pagination = $pagination;

        $this->util = $util;
    }
    /**
     * Returns list.
     *
     * @param array $input
     *
     * @return array
     */
    public function list(array $input): array
    {
        $ret = [];

        $limit = $input['limit'] ?? 30;
        $offset = $input['offset'] ?? 0;

        $search = new Search();

        if (isset($input['name'])) {
            $query = new WildcardQuery('name', sprintf('*%s*', $this->util->escape($input['name'])));
            $search->addQuery($query);
        }

        if (isset($input['parent'])) {
            $location = $input['parent'];

            $query = new TermQuery('parent', $location->getId());
            $search->addQuery($query);
        }

        if (isset($input['path'])) {
            $query = new WildcardQuery('path', sprintf('%s*', $this->util->escape($input['path'])));
            $search->addQuery($query);
        }

        $search->setFrom($offset);
        $search->setSize($limit);

        if ($input['order_by']) {
            $fld = key($input['order_by']);

            $ord = $input['order_by'][$fld];

            $sort = new FieldSort($fld, $ord);

            $search->addSort($sort);
        }

        $res = $this->documentService->search($this->locationIndex->name(), $search);

        $ret = \array_merge(
            $this->pagination->info($res['hits']['total']['value'], $limit, $offset),
            ['rows' => \array_column($res['hits']['hits'], '_source')]
        );

        return $ret;
    }
}
```

## Commands

### Server related commands

```php
// Pings server
php bin/console phoenix:elasticsearch:client ping

// Displays server info
php bin/console phoenix:elasticsearch:client info
```

### Index related commands

```php
// Creates index for location
php bin/console phoenix:elasticsearch:index --name=location create
```

```php
// Deletes index of location
php bin/console phoenix:elasticsearch:index --name=location delete
```

```php
// Checks whether index for location exists or not
php bin/console phoenix:elasticsearch:index --name=location exists
```

```php
// Displays settings of index for location
php bin/console phoenix:elasticsearch:index --name=location settings
```

```php
// Displays mappings of index for location
php bin/console phoenix:elasticsearch:index --name=location mappings
```

```php
// Updates settings in index for location
php bin/console phoenix:elasticsearch:index --name=location update-settings
```

```php
// Updates settings in index for location
php bin/console phoenix:elasticsearch:index --name=location update-mappings
```

### Document related commands

```php
// Index single document of location of ID given
php bin/console phoenix:elasticsearch:document --index=location --id=10 sync-by-id
```

```php
// Index all documents of location
php bin/console phoenix:elasticsearch:document --index=location sync
```

```php
// Delete all documents of location
php bin/console phoenix:elasticsearch:document --index=location delete-all
```

```php
// Delete single document of given ID of location
php bin/console phoenix:elasticsearch:document --index=location --id=10 delete-by-id
```

```php
// Displays document of given ID of location
php bin/console phoenix:elasticsearch:document --index=location --id=10 get
```

## Todo

- Autocomplete

## Roadmap

- Set bundle in packagist, make it composer friendly
- Index deletion - ask confirmation
- Pretty array with settings and mappings display on console
- Reindexing - https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-reindex.html
- Other APIs - https://www.elastic.co/guide/en/elasticsearch/reference/current/rest-apis.html
- Analyzer / tokenizer - https://www.elastic.co/guide/en/elasticsearch/reference/current/analysis.html
- Aggregation
- Remove bundle and convert this into component

## Brainstroming
