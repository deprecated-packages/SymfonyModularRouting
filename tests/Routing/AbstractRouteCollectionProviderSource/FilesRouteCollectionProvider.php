<?php

namespace Symplify\ModularRouting\Tests\Routing\AbstractRouteCollectionProviderSource;

use Symplify\ModularRouting\Routing\AbstractRouteCollectionProvider;

final class FilesRouteCollectionProvider extends AbstractRouteCollectionProvider
{
    /**
     * {@inheritdoc}
     */
    public function getRouteCollection()
    {
        return $this->loadRouteCollectionFromFiles([
            __DIR__.'/routes.xml',
            __DIR__.'/routes.yml',
        ]);
    }
}
