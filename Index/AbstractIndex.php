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
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::mappingsToUpdate()
     */
    public function mappingsToUpdate(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::settingsToUpdate()
     */
    public function settingsToUpdate(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::mappings()
     */
    abstract public function mappings(): array;

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Index\IndexInterface::settings()
     */
    abstract public function settings(): array;
}