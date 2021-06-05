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

use Phoenix\ElasticsearchBundle\Index\IndexInterface;
use Phoenix\ElasticsearchBundle\Search\SearchInterface;

/**
 * Class FinderInterface
 * @package Phoenix\ElasticsearchBundle\Finder
 * @author Hiren Chhatbar
 */
interface FinderInterface
{
    /**
     * Finds IndexInterface class.
     *
     * @return IndexInterface|SearchInterface
     */
    public function find(string $name);
}