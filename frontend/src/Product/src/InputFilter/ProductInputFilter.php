<?php

namespace Frontend\Product\InputFilter;

use Laminas\InputFilter\InputFilter;

/**
 * Used for Message Form validation
 */
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
            'name' => 'text',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => '<b>Message</b> is required and cannot be empty',
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
    }
}
