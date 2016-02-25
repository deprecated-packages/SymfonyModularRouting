<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\ModularRouting\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symplify\ModularRouting\Contract\Routing\RouteCollectionProviderInterface;

final class AddRouteCollectionProvidersCompilerPass implements CompilerPassInterface
{
    /**
     * @var ContainerBuilder
     */
    private $containerBuilder;

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;

        $modularRouterDefinition = $containerBuilder->getDefinition('symplify.modular_routing.modular_router');

        foreach ($this->getRouteCollectionProviders() as $name) {
            $modularRouterDefinition->addMethodCall('addRouteCollectionProvider', [new Reference($name)]);
        }
    }

    /**
     * @return string[]
     */
    private function getRouteCollectionProviders()
    {
        $routeCollectionProviders = [];
        foreach ($this->containerBuilder->getDefinitions() as $name => $definition) {
            if (is_subclass_of($definition->getClass(), RouteCollectionProviderInterface::class)) {
                $routeCollectionProviders[] = $name;
            }
        }

        return $routeCollectionProviders;
    }
}
