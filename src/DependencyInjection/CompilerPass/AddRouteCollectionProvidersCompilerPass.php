<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\ModularRouting\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class AddRouteCollectionProvidersCompilerPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    const TAG_ROUTE_COLLECTION_PROVIDER = 'symplify.route_collection_provider';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        $modularRouterDefinition = $containerBuilder->getDefinition('symplify.modular_routing.modular_router');
        $taggedServices = $containerBuilder->findTaggedServiceIds(self::TAG_ROUTE_COLLECTION_PROVIDER);

        foreach ($taggedServices as $serviceId => $attributes) {
            $modularRouterDefinition->addMethodCall('addRouteCollectionProvider', [new Reference($serviceId)]);
        }
    }
}
