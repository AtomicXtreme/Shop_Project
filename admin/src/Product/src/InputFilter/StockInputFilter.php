<?php

namespace Frontend\Product\InputFilter;

use Frontend\Product\Entity\Stock;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Digits;
use Laminas\Validator\InArray;

class StockInputFilter extends InputFilter
{
    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'nr',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => '<b>Number of products</b> is required and cannot be empty',
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
                    'type' => Digits::class,
                    'options' => [
                        'message' => '<b>Number of products</b> need to be int'
                    ]
                ]

            ]
        ]);
    }
}