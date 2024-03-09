<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\ElasticsearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Phoenix\ElasticsearchBundle\DependencyInjection
 * @author Hiren Chhatbar
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Returns TreeBuilder.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('phoenix_elasticsearch');

        //    $rootNode = $treeBuilder->root('phoenix_elasticsearch');

        return $treeBuilder;
    }
}
