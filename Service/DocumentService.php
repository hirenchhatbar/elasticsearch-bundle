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

/**
 * Class DocumentService
 * @package Phoenix\EasyElasticsearchBundle\Service
 * @author Hiren Chhatbar
 */
class DocumentService
{
    public function __construct(ClientService $clientService)
    {

    }

    /**
     * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/indexing_documents.html
     */
    public function insert()
    {

    }

    /**
     * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/updating_documents.html
     */
    public function update()
    {

    }

    /**
     * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/deleting_documents.html
     */
    public function delete()
    {
        ;
    }

    /**
     *
     * @return array
     *
     * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/getting_documents.html
     */
    public function get(): array
    {
        ;
    }
}