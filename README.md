# PhoenixEasyElasticsearchBundle

## Core library

- https://packagist.org/packages/elasticsearch/elasticsearch
- https://packagist.org/packages/ongr/elasticsearch-dsl

## Manual installation

- Clone repository.

```sh
# https://gitlab.com/phoenix-code-labs/phoenix/phoenix-easy-elasticsearch-bundle
git clone https://gitlab.com/phoenix-code-labs/phoenix/phoenix-easy-elasticsearch-bundle.git
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

        "Phoenix\\EasyElasticsearchBundle\\": "vendor/phoenix/easy-elasticsearch-bundle/"
    }
},
```

- Add new bundle in config/bundles.php.

```php
// config/bundles.php
return [
    Phoenix\EasyElasticsearchBundle\PhoenixEasyElasticsearchBundle::class => ['all' => true],
]
```
## Usage

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

## Brainstroming
