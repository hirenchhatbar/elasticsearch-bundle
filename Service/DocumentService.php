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

/**
 * Class DocumentService
 * @package Phoenix\ElasticsearchBundle\Service
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
     * It deletes documents from an index based on a query.
     *
     * @param string index The name of the index to delete from
     * @param array body The query to be used to delete the documents.
     *
     * @return The response from the deleteByQuery method.
     */
    public function deleteByQuery(string $index, array $body)
    {
        $params = [
            'index' => $index,
            'body' => $body,
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
        return $this->deleteByQuery($index, [
            'query' => [
                'match_all' => [],
            ]
        ]);
    }

    /**
     * "Search the index for the given body, optionally specifying the from and size parameters."
     *
     * @param string index The name of the index to search
     * @param array body The query to be executed.
     * @param int from The offset from the first result you want to fetch.
     * @param int size The number of results to return.
     *
     * @return The search results.
     */
    public function search(string $index, array $body, int $from = null, int $size = null, bool $trackTotalHits = false)
    {
        $params = [
            'index' => $index,
            'body' => $body,
        ];

        $params['track_total_hits'] = $trackTotalHits;

        if (null !== $from) {
            $params['from'] = $from;
        }

        if ($size) {
            $params['size'] = $size;
        }

        return $this->clientService->get()->search($params);
    }
}