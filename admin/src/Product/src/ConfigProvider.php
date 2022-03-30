<?php

declare(strict_types=1);

namespace Frontend\Product;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Dot\AnnotatedServices\Factory\AnnotatedServiceFactory;
use Frontend\Product\Form\ProductCategoryDelegator;
use Frontend\Product\Form\ProductForm;
use Frontend\Product\Form\ProductStockDelegator;
use Frontend\Product\Form\StockForm;
use Frontend\Product\Service\CategoryService;
use Frontend\Product\Service\CategoryServiceInterface;
use Frontend\Product\Service\OrderService;
use Frontend\Product\Service\ProductServiceInterface;
use Frontend\Product\Service\StockService;
use Frontend\User\Authentication\AuthenticationAdapter;
use Frontend\User\Authentication\AuthenticationAdapterFactory;
use Frontend\User\Authentication\AuthenticationServiceFactory;
use Frontend\User\Controller\AdminController;
use Frontend\User\Doctrine\EntityListenerResolver;
use Frontend\User\Doctrine\EntityListenerResolverFactory;
use Frontend\User\Entity\Admin;
use Frontend\User\Entity\AdminInterface;
use Frontend\User\Factory\AdminControllerFactory;
use Frontend\User\Factory\AdminRoleDelegator;
use Frontend\User\Factory\UserControllerFactory;
use Frontend\User\Factory\UserRoleDelegator;
use Frontend\User\Form\AdminForm;
use Frontend\User\Form\ChangePasswordForm;
use Frontend\User\Form\LoginForm;
use Frontend\User\Controller\UserController;
use Frontend\User\Form\UserForm;
use Frontend\User\Service\AdminService;
use Frontend\User\Service\UserRoleService;
use Frontend\User\Service\UserRoleServiceInterface;
use Frontend\User\Service\UserService;
use Frontend\User\Service\UserServiceInterface;
use Frontend\Product\Controller\ProductController;
use Frontend\Product\Factory\ProductControllerFactory;
use Frontend\Product\Service\ProductService;
use Laminas\Authentication\AuthenticationService;
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
            'doctrine' => $this->getDoctrineConfig(),
        ];
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {

        return [
            'factories'  => [
                ProductController::class => ProductControllerFactory::class,
                AdminController::class => AdminControllerFactory::class,
                EntityListenerResolver::class => EntityListenerResolverFactory::class,
                ProductService::class => AnnotatedServiceFactory::class,
                CategoryService::class => AnnotatedServiceFactory::class,
                StockService::class => AnnotatedServiceFactory::class,
                OrderService::class => AnnotatedServiceFactory::class,
                AdminService::class => AnnotatedServiceFactory::class,
                UserRoleService::class => AnnotatedServiceFactory::class,
                AdminForm::class => ElementFactory::class,
                UserForm::class => ElementFactory::class,
                ProductForm::class => ElementFactory::class,
                StockForm::class => ElementFactory::class,
                AuthenticationService::class => AuthenticationServiceFactory::class,
                AuthenticationAdapter::class => AuthenticationAdapterFactory::class,
            ],
            'aliases' => [
                AdminInterface::class => Admin::class,
                UserServiceInterface::class => UserService::class,
                UserRoleServiceInterface::class => UserRoleService::class,
                ProductServiceInterface::class => ProductService::class,
                CategoryServiceInterface::class => CategoryService::class,
            ],
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class
                ],
                ProductForm::class=>[
                    ProductCategoryDelegator::class
                ],
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

    public function getForms()
    {
        return [
            'form_manager' => [
                'factories' => [
                    LoginForm::class => ElementFactory::class,
                    ChangePasswordForm::class => ElementFactory::class
                ],
                'aliases' => [
                ],
                'delegators' => [
                ]
            ],
        ];
    }

    public function getDoctrineConfig()
    {
        return [
            'configuration' => [
                'orm_default' => [
                    'entity_listener_resolver' => EntityListenerResolver::class,
                ]
            ],
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
