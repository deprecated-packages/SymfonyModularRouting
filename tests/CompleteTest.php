<?php

namespace Symplify\ModularRouting\Tests;

use PHPUnit_Framework_TestCase;
use Symfony\Component\HttpKernel\Tests\Controller;
use Symfony\Component\Routing\RouterInterface;

final class CompleteTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var RouterInterface
     */
    private $router;

    protected function setUp()
    {
        $kernel = new AppKernel('test_env', true);
        $kernel->boot();

        $this->router = $kernel->getContainer()
            ->get('router');
    }

    public function testRouter()
    {
        $this->assertInstanceOf(RouterInterface::class, $this->router);
    }

    public function testMatchRouteFromRouteCollecionProvider()
    {
        $route = $this->router->match('/hello');
        $this->assertInternalType('array', $route);
        $this->assertSame(['_route' => 'my_route'], $route);
    }
}
