<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\ModularRouting\Routing;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symplify\ModularRouting\Contract\Routing\ModularRouterInterface;
use Symplify\ModularRouting\Contract\Routing\RouteCollectionProviderInterface;

final class ModularRouter implements ModularRouterInterface
{
    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @var RequestContext
     */
    private $requestContext;

    /**
     * @var UrlMatcherInterface
     */
    private $urlMatcher;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct()
    {
        $this->routeCollection = new RouteCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function addRouteCollectionProvider(RouteCollectionProviderInterface $routeCollectionProvider)
    {
        $this->routeCollection->addCollection($routeCollectionProvider->getRouteCollection());
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteCollection()
    {
        return $this->routeCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(RequestContext $requestContext)
    {
        $this->requestContext = $requestContext;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        return $this->getUrlGenerator()
            ->generate($name, $parameters, $referenceType);
    }

    /**
     * {@inheritdoc}
     */
    public function match($pathinfo)
    {
        return $this->getUrlMatcher()
            ->match($pathinfo);
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        // this method is never used
    }

    /**
     * @return UrlGeneratorInterface
     */
    private function getUrlGenerator()
    {
        if (null === $this->urlGenerator) {
            $this->urlGenerator = new UrlGenerator($this->getRouteCollection(), $this->requestContext);
        }

        return $this->urlGenerator;
    }

    /**
     * @return UrlMatcherInterface
     */
    private function getUrlMatcher()
    {
        if (null === $this->urlMatcher) {
            $this->urlMatcher = new UrlMatcher($this->getRouteCollection(), $this->requestContext);
        }

        return $this->urlMatcher;
    }
}
