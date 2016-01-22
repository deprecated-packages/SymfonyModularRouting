<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\ModularRouting\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symplify\ModularRouting\DependencyInjection\ClassListBuilder;
use Symplify\ModularRouting\Routing\AbstractRouteCollectionProvider;

final class SetLoaderCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        $classListBuilder = new ClassListBuilder($containerBuilder);
        $abstractRouteCollectionProviders = $classListBuilder->getByType(AbstractRouteCollectionProvider::class);

        foreach ($abstractRouteCollectionProviders as $serviceId) {

            $definition = $containerBuilder->getDefinition($serviceId);
            $definition->addMethodCall('setLoaderResolver', [new Reference('routing.resolver')]);
        }
    }
}
