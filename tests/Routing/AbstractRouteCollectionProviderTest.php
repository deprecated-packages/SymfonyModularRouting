<?php

namespace Symplify\ModularRouting\Tests\Routing;

use PHPUnit_Framework_TestCase;
use Symplify\ModularRouting\Exception\FileNotFoundException;
use Symplify\ModularRouting\Tests\Routing\AbstractRouteCollectionProviderSource\MissingFileRouteCollectionProvider;

final class AbstractRouteCollectionProviderTest extends PHPUnit_Framework_TestCase
{
    public function testMissingFiles()
    {
        $provider = new MissingFileRouteCollectionProvider();
        $this->setExpectedException(FileNotFoundException::class);
        $provider->getRouteCollection();
    }
}
