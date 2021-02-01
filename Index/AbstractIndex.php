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
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::mappingToUpdate()
     */
    public function mappingToUpdate(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::settingToUpdate()
     */
    public function settingToUpdate(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::mapping()
     */
    abstract public function mapping(): array;

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::setting()
     */
    abstract public function setting(): array;
}