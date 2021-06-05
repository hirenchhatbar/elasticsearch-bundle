<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\ElasticsearchBundle\Finder;

/**
 * Class AbstractFinder
 * @package Phoenix\ElasticsearchBundle\Finder
 * @author Hiren Chhatbar
 */
abstract class AbstractFinder implements FinderInterface
{
    /**
     * @var iterable
     */
    protected $handlers;

    /**
     * Constructor.
     *
     * @param iterable $handlers
     */
    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers;
    }
}