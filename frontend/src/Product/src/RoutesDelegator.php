<?php

namespace Frontend\Product;

use Fig\Http\Message\RequestMethodInterface;
use Frontend\Product\Controller\ProductController;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

/**
 * Class RoutesDelegator
 * @package Frontend\Product
 */

class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param $serviceName
     * @param callable $callback
     * @return Application
     */

    public function __invoke(ContainerInterface $container, $serviceName, callable $callback)
    {

        /** @var Application $app */
        $app = $callback();

        $app->route(
            '/product/[{action}[/{uuid}]]',
            ProductController::class,
            [RequestMethodInterface::METHOD_GET, RequestMethodInterface::METHOD_POST],
            'product'
        );

        return $app;
    }
}
