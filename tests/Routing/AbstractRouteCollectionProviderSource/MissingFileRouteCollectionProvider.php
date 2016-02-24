<?php

namespace Symplify\ModularRouting\Tests\Routing\AbstractRouteCollectionProviderSource;

use Symplify\ModularRouting\Routing\AbstractRouteCollectionProvider;

final class MissingFileRouteCollectionProvider extends AbstractRouteCollectionProvider
{
    /**
     * {@inheritdoc}
     */
    public function getRouteCollection()
    {
        return $this->loadRouteCollectionFromFile('incorrect-path.yml');
    }
}
