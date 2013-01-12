<?php

namespace Acme\Bundle\DicWorkshopBundle\DependencyInjection;

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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('acme_dic_workshop');

        $rootNode
            ->children()
                ->arrayNode('exchange_rates')
                    ->isRequired()
                    ->children()
                        ->scalarNode('endpoint')
                            ->info('sets url of the exchange rates webservice')
                            ->defaultValue('http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml')
                            ->validate()
                                ->ifTrue(function($value) {
                                    return !filter_var($value, \FILTER_VALIDATE_URL);
                                })
                                ->thenInvalid('The configuration value for "endpoint" must be a valid url.')
                            ->end()
                        ->end()
                        ->arrayNode('curl')
                            ->info('sets curl options')
                                ->useAttributeAsKey('name')
                            ->prototype('scalar')
                            ->end()
                            ->validate()
                                ->ifTrue(function($value) {
                                    $validOptions = array('CURLOPT_PROXY', 'CURLOPT_TIMEOUT');
                                    return count(array_intersect($validOptions, array_keys($value))) > count($validOptions);
                                })
                                ->thenInvalid('Valid curl options are CURLOPT_PROXY and CURLOPT_TIMEOUT.')
                            ->end()
                        ->end()
                        ->arrayNode('cache')
                            ->info('selects guzzle/doctrine cache adapters')
                            ->performNoDeepMerging()
                            ->children()
                                ->scalarNode('file')->end()
                                // TODO: config for other adapters
                            ->end()
                            ->validate()
                                ->ifTrue(function($value) {
                                    $keys = array_keys($value);
                                    return count($keys) != 1 || !in_array(current($keys), array('file', 'apc'));
                                })
                                ->thenInvalid('You must configure exactly one of: [file, apc].')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
