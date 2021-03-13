<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\EasyElasticsearchBundle\Finder;

use Phoenix\EasyElasticsearchBundle\Search\SearchInterface;

/**
 * Class SearchFinder
 * @package Phoenix\EasyElasticsearchBundle\Finder
 * @author Hiren Chhatbar
 */
class SearchFinder extends AbstractFinder
{
    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\EasyElasticsearchBundle\Finder\FinderInterface::find()
     */
    public function find(string $name): SearchInterface
    {
        foreach ($this->handlers as $handler) {
            if ($name == get_class($handler) || is_subclass_of($handler, $name)) {
                return $handler;
            }
        }

        throw new \Exception(sprintf('Search %s not found', $name));
    }
}