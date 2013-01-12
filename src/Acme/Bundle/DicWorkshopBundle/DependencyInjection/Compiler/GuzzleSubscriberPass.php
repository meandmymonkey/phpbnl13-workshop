<?php

namespace Acme\Bundle\DicWorkshopBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class GuzzleSubscriberPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('acme_dic_workshop.httpclient')) {
            return;
        }

        $subscriberIds = $container->findTaggedServiceIds('acme_dic_workshop.guzzle_subscriber');
        $guzzleClient = $container->getDefinition('acme_dic_workshop.httpclient');

        foreach (array_keys($subscriberIds) as $id) {
            $guzzleClient->addMethodCall('addSubscriber', array(new Reference($id)));
        }
    }
}
