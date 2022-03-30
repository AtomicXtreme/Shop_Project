<?php

namespace Frontend\Product\Form;

use Frontend\Product\Service\ProductService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProductCategoryDelegator implements DelegatorFactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param $name
     * @param callable $callback
     * @param array|null $options
     * @return ProductForm|mixed|object
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $productForm = $callback();
        if ($productForm instanceof ProductForm) {
            /** @var ProductService $productService */
            $productService = $container->get(ProductService::class);
            $category = $productService->getProductFormProcessedCategory();

            $productForm->setCategory($category);
        }

        return $productForm;
    }
}