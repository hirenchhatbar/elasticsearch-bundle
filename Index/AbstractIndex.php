<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\EasyElasticsearchBundle\Index;

use Phoenix\EasyElasticsearchBundle\Document\AbstractDocument;

/**
 * Class AbstractIndex
 * @package Phoenix\EasyElasticsearchBundle\Index
 * @author Hiren Chhatbar
 */
abstract class AbstractIndex implements IndexInterface
{
    /**
     * Holds the name of index.
     *
     * @var string
     */
    public string $name;

    /**
     * Prefix of name.
     *
     * @var string
     */
    protected string $prefix = '';

    /**
     * Holds object of AbstractDocument.
     *
     * @var AbstractDocument
     */
    protected AbstractDocument $document;

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::mappingsToUpdate()
     */
    public function mappingsToUpdate(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::settingsToUpdate()
     */
    public function settingsToUpdate(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::mappings()
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping-types.html
     */
    abstract public function mappings(): array;

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::settings()
     */
    abstract public function settings(): array;

    /**
     * Returns default settings.
     *
     * @return array
     */
    final protected function defaultSettings(): array
    {
        return [
            // The maximum value of from + size for searches to this index. Defaults to 10000. Search requests take heap memory and time proportional to from + size and this limits that memory
            'max_result_window' => 251000,

            // The maximum number of fields in an index. Field and object mappings, as well as field aliases count towards this limit. The default value is 1000
            'index.mapping.total_fields.limit' => 3000,

            // How often to perform a refresh operation, which makes recent changes to the index visible to search. Defaults to 1s.
            'refresh_interval' => '30s',

            // The number of primary shards that an index should have. Defaults to 1.
            'number_of_shards' => 1,

            // The number of replicas each primary shard has. Defaults to 1.
            'number_of_replicas' => 1,
        ];
    }

    /**
     * Returns default mappings.
     *
     * @return array
     */
    final protected function defaultMappings(): array
    {
        return [
            '_source' => [
                'enabled' => true,
            ],
            'properties' => [
                'id' => [
                    'type' => 'integer',
                ],
                'created_at' => [
                    'type' => 'integer',
                ],
                'updated_at' => [
                    'type' => 'integer',
                ],
            ]
        ];
    }

    /**
     * Returns mappings for translation field
     *
     * @return array
     */
    final protected function translationMapping(): array
    {
        return [
            'properties' => [
                'translation' => [
                    'type' => 'nested',
                    'properties' => [
                        'field' => [
                            'type' => 'text',
                        ],
                        'locale' => [
                            'type' => 'text',
                        ],
                        'content' => [
                            'type' => 'text',
                        ],
                    ],
                ],
            ]
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::document()
     */
    final public function document(): AbstractDocument
    {
        return $this->document;
    }

    /**
     * Sets prefix.
     *
     * @param string $value
     */
    final public function setPrefix(string $value): void
    {
        $this->prefix = $value;
    }

    /**
     * Returns FQDN name of index.
     *
     * @param string $name
     *
     * @return string
     */
    final public function name(): string
    {
        return sprintf('%s%s', $this->prefix, $this->name);
    }
}