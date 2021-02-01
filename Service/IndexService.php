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

use Elasticsearch\Client;

/**
 * Class IndexService
 * @package Phoenix\EasyElasticsearchBundle\Service
 * @author Hiren Chhatbar
 * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/index_management.html
 */
class IndexService
{
    /**
     * Holds ES client.
     *
     * @var Client
     */
    protected Client $client;

    /**
     * Constructor.
     *
     * @param ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->client = $clientService->get();
    }

    public function create()
    {

    }

    public function delete()
    {

    }

    public function exists()
    {

    }

    public function mapping(): array
    {

    }

    public function setting(): array
    {

    }

    public function updateMapping()
    {

    }

    public function updateSetting()
    {

    }
}