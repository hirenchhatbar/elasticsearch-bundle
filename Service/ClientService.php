<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\ElasticsearchBundle\Service;

use Elasticsearch\ClientBuilder;
use Elasticsearch\Client;

/**
 * Class ClientService
 * @package Phoenix\ElasticsearchBundle\Service
 * @author Hiren Chhatbar
 * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/connceting.html
 * @link https://symfony.com/doc/current/service_container/shared.html
 */
class ClientService
{
    /**
     * Holds hosts.
     *
     * @var array
     */
    protected array $hosts;

    /**
     * Holds object of Client.
     *
     * @var Client
     */
    protected Client $client;

    /**
     * Constructor.
     *
     * @param array $hosts
     */
    public function __construct(array $hosts)
    {
        $this->hosts = $hosts;

        if (!isset($this->client)) {
            $this->set();
        }
    }

    /**
     * Returns ES client.
     *
     * @return Client
     */
    public function get(): Client
    {
        return $this->client;
    }

    /**
     * Sets client.
     */
    public function set(): void
    {
        $this->client = ClientBuilder::create()
            ->setHosts($this->hosts)
            ->build()
        ;
    }
}