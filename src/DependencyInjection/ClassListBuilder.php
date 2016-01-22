<?php

declare (strict_types = 1);

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\ModularRouting\DependencyInjection;

use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ClassListBuilder
{
    /**
     * @var string[]
     */
    private $classList = [];

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->build($containerBuilder);
    }

    /**
     * @return string[]|array
     */
    public function getByType(string $type) : array
    {
        if (isset($this->classList[$type])) {
            return $this->classList[$type];
        }

        return [];
    }

    private function build(ContainerBuilder $containerBuilder)
    {
        $parameterBag = $containerBuilder->getParameterBag();

        foreach ($containerBuilder->getDefinitions() as $serviceId => $definition) {
            $class = $parameterBag->resolveValue($definition->getClass());
            if (null === $class) {
                continue;
            }

            if (!class_exists($class)) {
                continue;
            }

            $this->processClass($serviceId, $class);
        }
    }

    private function processClass(string $serviceId, string $class)
    {
        $reflection = new ReflectionClass($class);
        if (!$reflection) {
            return;
        }

        $this->classList[$reflection->getName()][] = $serviceId;
        foreach ($reflection->getInterfaceNames() as $interface) {
            $this->classList[$interface][] = $serviceId;
        }

        $parent = $reflection;
        while (($parent = $parent->getParentClass())) {
            $this->classList[$parent->getName()][] = $serviceId;
        }
    }
}
