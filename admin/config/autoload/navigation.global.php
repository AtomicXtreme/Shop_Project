<?php

declare(strict_types=1);

return [
    'dot_navigation' => [

        //enable menu item active if any child is active
        'active_recursion' => true,

        'containers' => [
            'main_menu' => [
                'type' => 'ArrayProvider',
                'options' => [
                    'items' => [
                        [
                            'options' => [
                                'label' => 'Dashboard',
                                'route' => [
                                    'route_name' => 'dashboard',
                                ],
                                'icon' => 'fas fa-tachometer-alt',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Manage admins',
                                'route' => [
                                    'route_name' => 'admin',
                                    'route_params' => ['action' => 'manage']
                                ],
                                'icon' => 'fas fa-user-circle',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Manage users',
                                'route' => [
                                    'route_name' => 'user',
                                    'route_params' => ['action' => 'manage']
                                ],
                                'icon' => 'fas fa-user',
                            ],
                        ],
                        [
                            'options' => [
                                'label' => 'Manage products',
                                'route' => [
                                    'route_name' => 'product',
                                    'route_params' => ['action' => 'manageProducts']
                                ],
                                'icon' => 'fas fa-shopping-cart ',
                            ],
                        ],

                        [
                            'options' => [
                                'label' => 'Manage orders',
                                'route' => [
                                    'route_name' => 'product',
                                    'route_params' => ['action' => 'manageOrders']
                                ],
                                'icon' => 'fas fa-dollar-sign',
                            ],
                        ],

                    ]
                ]
            ],

            'account_menu' => [
                'type' => 'ArrayProvider',
                'options' => [
                    'items' => [
                        [
                            'options' => [
                                'label' => 'Profile',
                                'route' => [
                                    'route_name' => 'admin',
                                    'route_params' => ['action' => 'account']
                                ],
                                'icon' => 'fas fa-user',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Settings',
                                'route' => [
                                    'route_name' => 'dashboard',
                                ],
                                'icon' => 'fas fa-cog',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Sign Out',
                                'route' => [
                                    'route_name' => 'admin',
                                    'route_params' => ['action' => 'logout']
                                ],
                                'icon' => 'fas fa-sign-out-alt',
                            ]
                        ]
                    ]
                ]
            ]
        ],

        //register custom providers here
        'provider_manager' => []
    ],
];
