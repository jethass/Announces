<?php

namespace Annonces\SiteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
       
        $rootNode = $treeBuilder->root('annonces_site');
        $rootNode
                 ->children()
                            ->arrayNode('pagination')
                                                ->addDefaultsIfNotSet()
                                                ->children()
                                                    ->integerNode('max_per_page')->min(1)->defaultValue(50)->end()
                                                ->end()
                                            ->end()
                                        ->end()
                            ;

       


        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
