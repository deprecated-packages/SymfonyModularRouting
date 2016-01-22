# Modular Routing

[![Build Status](https://img.shields.io/travis/Symplify/ModularRouting.svg?style=flat-square)](https://travis-ci.org/Symplify/ModularRouting)
[![Quality Score](https://img.shields.io/scrutinizer/g/Symplify/ModularRouting.svg?style=flat-square)](https://scrutinizer-ci.com/g/Symplify/ModularRouting)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/Symplify/ModularRouting.svg?style=flat-square)](https://scrutinizer-ci.com/g/Symplify/ModularRouting)
[![Downloads](https://img.shields.io/packagist/dt/symplify/modular-routing.svg?style=flat-square)](https://packagist.org/packages/symplify/modular-routing)
[![Latest stable](https://img.shields.io/packagist/v/symplify/modular-routing.svg?style=flat-square)](https://packagist.org/packages/symplify/modular-routing)

To add routes you usually need to add few lines to `app/config/routing.yml`. If you have over dozens of modules, it would be easy to get lost in it.
**Thanks to this router, you can add them easily as via service loader**.

## Install

```bash
$ composer require symplify/modular-routing
```

Add bundle to `AppKernel.php`:

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            new Symplify\ModularRouting\SymplifyModularRoutingBundle(),
            // ...
        ];
    }
}
```


## Usage

**1. Implement `RouteCollectionProviderInterface`**

```php
use Symplify\ModularRouting\Contract\Routing\RouteCollectionProviderInterface;

final class SomeRouteCollectionProvider implements RouteCollectionProviderInterface
{
    public function getRouteCollection() : RouteCollection
    {
        $routeCollection = new RouteCollection();
        $routeCollection->add('my_route', new Route('/hello'));

        return $routeCollection;
    }
}
```

**2. Register service with "symplify.route_collection_provider" tag**

```yml
some_module.route_provider:
    class: SomeModule\Routing\SomeRouteCollectionProvider
    tags:
        - { name: symplify.route_collection_provider }
```

That's all!


# Testing

```bash
$ vendor/bin/phpunit
```


# Contributing

Rules are simple:

- new feature needs tests
- all tests must pass
- 1 feature per PR

I'd be happy to merge your feature then.
