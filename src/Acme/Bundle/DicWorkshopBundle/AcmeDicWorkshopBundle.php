<?php

namespace Acme\Bundle\DicWorkshopBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Acme\Bundle\DicWorkshopBundle\DependencyInjection\Compiler\GuzzleSubscriberPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AcmeDicWorkshopBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new GuzzleSubscriberPass());
    }
}
