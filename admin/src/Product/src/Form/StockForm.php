<?php

namespace Frontend\Product\Form;

use Frontend\Product\Entity\Stock;
use Frontend\Product\InputFilter\StockInputFilter;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

class StockForm extends Form
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

        $this->inputFilter = new StockInputFilter();
        $this->inputFilter->init();
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'nr',
            'options' => [
                'label' => 'Number of products'
            ],
            'attributes' => [
                'id' => 'stockNr',
            ],
            'type' => Text::class,
        ]);

    }

    /**
     * @return null|InputFilter|InputFilterInterface
     */
    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }
}