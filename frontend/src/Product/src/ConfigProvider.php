<?php

declare(strict_types=1);

namespace Frontend\Product;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Dot\AnnotatedServices\Factory\AnnotatedServiceFactory;
use Frontend\Product\Controller\ProductController;
use Frontend\Product\Entity\Category;
use Frontend\Product\Service\ProductService;
use Frontend\Product\Service\ProductServiceInterface;
use Frontend\Product\Service\CategoryService;
use Frontend\Product\Service\CategoryServiceInterface;
use Frontend\Product\Service\MessageService;
use Frontend\Product\Service\MessageServiceInterface;
use Frontend\Product\Service\StockService;
use Frontend\Product\Service\StockServiceInterface;
use Frontend\Product\Service\VoteService;
use Frontend\Product\Service\VoteServiceInterface;
use Laminas\Form\ElementFactory;
use Mezzio\Application;

/**
 * Class ConfigProvider
 * @package Frontend\Product
 */
class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'dot_form' => $this->getForms(),
            'doctrine' => $this->getDoctrineConfig()
        ];
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class,
                ],
            ],
            'factories'  => [
                ProductController::class => AnnotatedServiceFactory::class,
                ProductService::class => AnnotatedServiceFactory::class,
            ],
            'aliases' => [
                ProductServiceInterface::class => ProductService::class,
                CategoryServiceInterface::class => CategoryService::class,
                MessageServiceInterface::class => MessageService::class,
                StockServiceInterface::class => StockService::class,
                VoteServiceInterface::class => VoteService::class,
            ]
        ];
    }

    /**
     * @return array
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'product' => [__DIR__ . '/../templates/product']
            ],
        ];
    }

    /**
     * @return array
     */
    public function getForms()
    {
        return [
            'form_manager' => [
                'factories' => [

                ],
                'aliases' => [
                ],
            ],
        ];
    }

    public function getDoctrineConfig()
    {
        return [
            'driver' => [
                'orm_default' => [
                    'drivers' => [
                        'Frontend\Product\Entity' => 'ProductEntities',
                    ]
                ],
                'ProductEntities' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ]
            ]
        ];
    }
}
