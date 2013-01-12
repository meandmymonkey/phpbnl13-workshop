<?php

namespace Acme\Bundle\DicWorkshopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AcmeDicWorkshopExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('exchangerates.xml');

        $container->setParameter('acme_dic_workshop.httpclient.curl_options', $config['exchange_rates']['curl']);
        $container->setParameter('acme_dic_workshop.adapter.endpoint', $config['exchange_rates']['endpoint']);

        if (isset($config['exchange_rates']['cache'])) {
            $loader->load('cache.xml');

            $type = current(array_keys($config['exchange_rates']['cache']));

            switch ($type) {
                case 'file':
                    $container->setParameter('acme_dic_workshop.guzzle.cache_adapter.file.dir', $config['exchange_rates']['cache']['file']);
                    break;
            }

            $container->setAlias(
                'acme_dic_workshop.guzzle.cache_adapter',
                sprintf('acme_dic_workshop.guzzle.cache_adapter.%s', $type)
            );
        }
    }
}
