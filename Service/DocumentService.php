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

use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;

/**
 * Class DocumentService
 * @package Phoenix\EasyElasticsearchBundle\Service
 * @author Hiren Chhatbar
 */
class DocumentService
{
    /**
     * Holds object of ClientService.
     *
     * @var ClientService
     */
    protected ClientService $clientService;

    /**
     * Constructor.
     *
     * @param ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * Indexes.
     *
     * @param string $index
     * @param int $id
     * @param array $data
     *
     * @return array|callable
     *
     * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/indexing_documents.html
     */
    public function index(string $index, int $id, array $data)
    {
        $params = [
            'index' => $index,
            'id'    => $id,
            'body'  => $data,
        ];

        return $this->clientService->get()->index($params);
    }

    /**
     * Indexes in bulk.
     *
     * @param string $index
     * @param array $rows
     * @param string $idField
     *
     * @return array|callable
     *
     * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/indexing_documents.html
     */
    public function indexBulk(string $index, array $rows, string $idField = 'id')
    {
        $params = [];

        foreach ($rows as $row) {
            $indexArray = [
                '_index' => $index,
            ];

            if ($idField) {
                $indexArray['_id'] = $row[$idField];
            }

            $params['body'][] = [
                'index' => $indexArray
            ];

            $params['body'][] = $row;
        }

        return $this->clientService->get()->bulk($params);
    }

    /**
     * Updates document.
     *
     * @param string $index
     * @param int $id
     * @param array $data
     * @return array|callable
     *
     * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/updating_documents.html
     */
    public function update(string $index, int $id, array $data)
    {
        $params = [
            'index' => $index,
            'id'    => $id,
            'body'  => [
                'doc' => $data,
            ]
        ];

        // Update doc at /my_index/_doc/my_id
        return $this->clientService->get()->update($params);
    }

    /**
     * Deletes document by given ID.
     *
     * @param string $index
     * @param int $id
     *
     * @return array|callable
     *
     * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/deleting_documents.html
     */
    public function delete(string $index, int $id)
    {
        $params = [
            'index' => $index,
            'id'    => $id,
        ];

        // Delete doc at /my_index/_doc_/my_id
        return $this->clientService->get()->delete($params);
    }

    /**
     * Returns document by given ID.
     *
     * @param string $index
     * @param int $id
     *
     * @return array
     *
     * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/getting_documents.html
     */
    public function get(string $index, int $id): array
    {
        $params = [
            'index' => $index,
            'id'    => $id,
        ];

        // Get doc at /my_index/_doc/my_id
        return $this->clientService->get()->get($params);
    }

    /**
     * Deletes by query.
     *
     * @param string $index
     * @param Search $search
     *
     * @return array|callable
     *
     * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-delete-by-query.html
     */
    public function deleteByQuery(string $index, Search $search)
    {
        $params = [
            'index' => $index,
            'body' => $search->toArray(),
        ];

        return $this->clientService->get()->deleteByQuery($params);
    }

    /**
     * Deletes all documents in given index.
     *
     * @param string $index
     *
     * @return array|callable
     */
    public function deleteAll(string $index)
    {
        $matchAll = new MatchAllQuery();

        $search = new Search();
        $search->addQuery($matchAll);

        return $this->deleteByQuery($index, $search);
    }
}