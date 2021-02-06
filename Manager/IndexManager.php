<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\EasyElasticsearchBundle\Manager;

use Phoenix\EasyElasticsearchBundle\Index\AbstractIndex;
use Phoenix\EasyElasticsearchBundle\Service\IndexService;

/**
 * Class IndexManager
 * @package Phoenix\EasyElasticsearchBundle\Manager
 * @author Hiren Chhatbar
 */
class IndexManager
{
    /**
     * Holds index service provider class.
     *
     * @var IndexService
     */
    protected IndexService $indexService;

    /**
     * Holds index upon which all the operations to be performed.
     *
     * @var AbstractIndex
     */
    protected AbstractIndex $index;

    /**
     * Holds the prefix appended before name of index.
     *
     * @var string
     */
    protected string $indexPrefix;

    /**
     * Constructor.
     *
     * @param IndexService $indexService
     */
    public function __construct(IndexService $indexService, string $indexPrefix)
    {
        $this->indexService = $indexService;

        $this->indexPrefix = $indexPrefix;
    }

    /**
     * Inits manager.
     *
     * @param AbstractIndex $index
     *
     * @return \Phoenix\EasyElasticsearchBundle\Manager\IndexManager
     */
    public function init(AbstractIndex $index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * Creates index.
     *
     * @return array
     */
    public function create(): array
    {
        return $this->indexService->create(
            $this->name(),
            $this->index->settings(),
            $this->index->mappings()
        );
    }

    /**
     * Deletes index.
     *
     * @return array
     */
    public function delete(): array
    {
        return $this->indexService->delete($this->name());
    }

    /**
     * Checks whether index exist or not.
     *
     * @param string $index
     *
     * @return bool
     */
    public function exists(): bool
    {
        return $this->indexService->exists($this->name());
    }

    /**
     * Returns settings.
     *
     * @return array
     */
    public function settings(): array
    {
        return $this->indexService->settings($this->name());
    }

    /**
     * Returns mapping.
     *
     * @return array
     */
    public function mappings(): array
    {
        return $this->indexService->mappings($this->name());
    }

    /**
     * Updates settings.
     *
     * @return array
     */
    public function updateSettings(): array
    {
        return $this->indexService->updateSettings($this->name(), $this->index->settingsToUpdate());
    }

    /**
     * Updates mappings.
     *
     * @return array
     */
    public function updateMappings(): array
    {
        return $this->indexService->updateMappings($this->name(), $this->index->mappingsToUpdate());
    }

    /**
     * Returns FQDN name of index.
     *
     * @param string $name
     *
     * @return string
     */
    public function name(): string
    {
        return sprintf('%s%s', $this->indexPrefix, $this->index->name);
    }
}