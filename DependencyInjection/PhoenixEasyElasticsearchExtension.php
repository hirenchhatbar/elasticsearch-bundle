<?php

/*
 * This file is part of the Phoenix package.
 *
 * (c) Hiren Chhatbar <hc.rajkot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phoenix\EasyElasticsearchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Class PhoenixEasyElasticsearchExtension
 * @package Phoenix\EasyElasticsearchBundle\DependencyInjection
 * @author Hiren Chhatbar
 */
class PhoenixEasyElasticsearchExtension extends Extension
{
    /**
     * Loads.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('parameters.yaml');

        $loader->load('services.yaml');
        $loader->load('services_commands.yaml');
        $loader->load('services_indexes.yaml');
        $loader->load('services_documents.yaml');
        $loader->load('services_searches.yaml');
        $loader->load('services_finders.yaml');
    }
}
