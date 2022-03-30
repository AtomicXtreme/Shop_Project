<?php

namespace Frontend\Product\InputFilter;

use Frontend\Product\Entity\Product;
use Laminas\Filter\Digits;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\InArray;

class ProductInputFilter extends InputFilter
{
    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => '<b>Title</b> is required and cannot be empty',
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 1000
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'description',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => '<b>Description</b> is required and cannot be empty',
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 1000
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'category',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => '<b>Category</b> is required and cannot be empty',
                    ]
                ],
            ]
        ]);

        $this->add([
            'name' => 'img',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => '<b>Image</b> is required and cannot be empty',
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 1000
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'price',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => '<b>Price</b> is required and cannot be empty',
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 1000
                    ]
                ],

                [
                    'name' => 'Int',
                    'type' => \Laminas\Validator\Digits::class,
                    'options' => [
                        'message' => '<b>Price</b> need to be int'
                ]
            ]

            ]
        ]);

        $this->add([
            'name' => 'status',
            'required' => true,
            'filters' => [],
            'validators' => [
                [
                    'name' => InArray::class,
                    'options' => [
                        'haystack' => [
                            Product::STATUS_AVAILABLE,
                            Product::STATUS_UNAVAILABLE
                        ]
                    ],
                ]
            ]
        ]);
    }
}
