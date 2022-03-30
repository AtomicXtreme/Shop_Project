<?php

namespace Frontend\Product\Form;

use Frontend\Product\InputFilter\ProductInputFilter;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;

class MessageForm extends Form
{
    /** @var InputFilter $inputFilter */
    protected $inputFilter;

    /**
     * ProductForm constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new ProductInputFilter();
        $this->inputFilter->init();
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'title',
            'options' => [
                'label' => 'Title'
            ],
            'attributes' => [
                'id' => 'userMessage_title',
                'placeholder' => 'Title...',
            ],
            'type' => Text::class,
        ]);

        $this->add([
            'name' => 'text',
            'options' => [
                'label' => 'Message'
            ],
            'attributes' => [
                'id' => 'userMessage_textarea',
                'placeholder' => 'Message...',
                'rows' => 5,
            ],
            'type' => Textarea::class,
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Send message'
            ]
        ], ['priority' => -105]);
    }

    /**
     * @return null|InputFilter|\Laminas\InputFilter\InputFilterInterface
     */
    public function getInputFilter(): \Laminas\InputFilter\InputFilterInterface
    {
        return $this->inputFilter;
    }
}