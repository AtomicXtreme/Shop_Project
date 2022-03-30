<?php

declare(strict_types=1);

namespace Frontend\Product\Factory;

use Dot\FlashMessenger\FlashMessenger;
use Frontend\App\Plugin\FormsPlugin;
use Frontend\Product\Controller\ProductController;
use Frontend\Product\Form\ProductForm;
use Frontend\Product\Form\StockForm;
use Frontend\Product\Service\CategoryService;
use Frontend\Product\Service\OrderService;
use Frontend\Product\Service\ProductService;
use Frontend\Product\Service\StockService;
use Laminas\Authentication\AuthenticationService;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class UserControllerFactory
 * @package Frontend\Contact\Factory
 */
class ProductControllerFactory
{
    /**
     * @param ContainerInterface $container
     * @return ProductController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        $router = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);
        $productService = $container->get(ProductService::class);
        $categoryService = $container->get(CategoryService::class);
        $stockService = $container->get(StockService::class);
        $orderService = $container->get(OrderService::class);
        $messenger = $container->get(FlashMessenger::class);
        $auth = $container->get(AuthenticationService::class);
        $forms = $container->get(FormsPlugin::class);
        $productForm = $container->get(ProductForm::class);
        $stockForm = $container->get(StockForm::class);


        return new ProductController(
            $productService,
            $categoryService,
            $stockService,
            $orderService,
            $router,
            $template,
            $auth,
            $messenger,
            $forms,
            $productForm,
            $stockForm,
        );
    }
}