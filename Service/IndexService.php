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
 * Class IndexService
 * @package Phoenix\ElasticsearchBundle\Service
 * @author Hiren Chhatbar
 * @link https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/index_management.html
 */
class IndexService
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
     * Creates index.
     *
     * @param string $index
     * @param array $settings
     * @param array $mappings
     *
     * @return array
     */
    public function create(string $index, array $settings = [], array $mappings = []): array
    {
        $params = [
            'index' => $index,
            'body' => [],
        ];

        if (\count($settings)) {
            $params['body']['settings'] = $settings;
        }

        if (\count($mappings)) {
            $params['body']['mappings'] = $mappings;
        }

        return $this->clientService->get()->indices()->create($params);
    }

    /**
     * Deletes index.
     *
     * @param string $index
     *
     * @return array
     */
    public function delete(string $index): array
    {
        return $this->clientService->get()->indices()->delete(['index' => $index]);
    }

    /**
     * Checks whether index exist or not.
     *
     * @param string $index
     *
     * @return bool
     */
    public function exists(string $index): bool
    {
        return $this->clientService->get()->indices()->exists(['index' => $index]);
    }

    /**
     * Returns settings of index given.
     *
     * @param string $index
     *
     * @return array
     */
    public function settings(string $index): array
    {
        return $this->clientService->get()->indices()->getSettings(['index' => $index]);
    }

    /**
     * Returns mapping of index given.
     *
     * @param string $index
     *
     * @return array
     */
    public function mappings(string $index): array
    {
        return $this->clientService->get()->indices()->getMapping(['index' => $index]);
    }

    /**
     * Updates settings.
     *
     * @param string $index
     * @param array $settings
     *
     * @return array
     */
    public function updateSettings(string $index, array $settings): array
    {
        $params = [
            'index' => $index,
            'body' => [
                'settings' => $settings,
            ],
        ];

        return $this->clientService->get()->indices()->putSettings($params);
    }

    /**
     * Updates mappings.
     *
     * @param string $index
     * @param array $mappings
     *
     * @return array
     */
    public function updateMappings(string $index, array $mappings): array
    {
        $params = [
            'index' => $index,
            'body' => $mappings,
        ];

        return $this->clientService->get()->indices()->putMapping($params);
    }
}