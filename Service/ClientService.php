<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\EasyElasticsearchBundle\Service;

use Elasticsearch\ClientBuilder;
use Elasticsearch\Client;

/**
 * Class ClientService
 * @package Phoenix\EasyElasticsearchBundle\Service
 * @author Hiren Chhatbar
 * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/connceting.html
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
     * Constructor.
     *
     * @param array $hosts
     */
    public function __construct(array $hosts)
    {
        $this->hosts = $hosts;
    }

    /**
     * Returns client.
     *
     * @return Client
     */
    public function get(): Client
    {
        $client = ClientBuilder::create()
            ->setHosts($this->hosts)
            ->build()
        ;

        return $client;
    }
}