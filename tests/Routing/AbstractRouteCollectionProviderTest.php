<?php

namespace Symplify\ModularRouting\Tests\Routing;

use PHPUnit_Framework_TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Loader\XmlFileLoader;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symplify\ModularRouting\Routing\AbstractRouteCollectionProvider;
use Symplify\ModularRouting\Tests\Routing\AbstractRouteCollectionProviderSource\FilesRouteCollectionProvider;

final class AbstractRouteCollectionProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractRouteCollectionProvider
     */
    private $provider;

    protected function setUp()
    {
        $this->provider = new FilesRouteCollectionProvider();
        $this->provider->setLoaderResolver($this->getLoaderResolver());
    }

    public function testGetRouteCollection()
    {
        $routeCollection = $this->provider->getRouteCollection();

        $this->assertInstanceOf(RouteCollection::class, $routeCollection);
    }

    public function testLoadYamlRoutes()
    {
        $routeCollection = $this->provider->getRouteCollection();

        $route = $routeCollection->get('some_route');
        $this->assertInstanceOf(Route::class, $route);
        $this->assertSame('/some-path', $route->getPath());
        $this->assertSame('SomeController', $route->getDefault('_controller'));
    }

    public function testLoadXmlRoutes()
    {
        $routeCollection = $this->provider->getRouteCollection();

        $route = $routeCollection->get('another_route');
        $this->assertInstanceOf(Route::class, $route);
        $this->assertSame('/another-path', $route->getPath());
        $this->assertSame('AnotherController', $route->getDefault('_controller'));
    }

    /**
     * @return LoaderResolverInterface
     */
    private function getLoaderResolver()
    {
        $loaderResolver = new LoaderResolver();
        $loaderResolver->addLoader(new YamlFileLoader(new FileLocator([])));
        $loaderResolver->addLoader(new XmlFileLoader(new FileLocator([])));
        return $loaderResolver;
    }
}
