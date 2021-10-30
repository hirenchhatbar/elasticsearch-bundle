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

use Phoenix\ElasticsearchBundle\Search\SearchInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * Class SearchFinder.
 *
 * @author Hiren Chhatbar
 */
class SearchFinder extends AbstractFinder
{
    /**
     * @var ServiceLocator
     */
    protected $locator;

    /**
     * Constructor.
     */
    public function __construct(ServiceLocator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * {@inheritDoc}
     *
     * @see \Phoenix\ElasticsearchBundle\Finder\FinderInterface::find()
     */
    public function find(string $name): SearchInterface
    {
        if ($this->locator->has($name)) {
            return $this->locator->get($name);
        }

        throw new \Exception(sprintf('Search %s not found', $name));
    }
}
