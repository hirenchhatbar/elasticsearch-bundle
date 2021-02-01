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
     * Returns FQDN name of index.
     *
     * @param string $name
     *
     * @return string
     */
    protected function name(string $name): string
    {
        return sprintf('%s%s', $this->indexPrefix, $name);
    }
}