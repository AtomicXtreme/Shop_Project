<?php

namespace Frontend\Product\Form;

use Frontend\Product\Entity\Product;
use Frontend\Product\Fieldset\ProductImageFieldset;
use Frontend\Product\FormData\ProductFormData;
use Frontend\Product\InputFilter\ProductInputFilter;
use Laminas\Filter\Digits;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Form;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

class ProductForm extends Form
{
    /** @var InputFilter $inputFilter */
    protected $inputFilter;
    protected array $categoryType = [];

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

    /**
     * @param array $categoryType
     */
    public function setCategory(array $categoryType): void
    {

        $this->categoryType = $categoryType;

        $this->add([
            'name' => 'category',
            'type' => 'select',
            'options' => [
                'empty_option' => 'Please choose category',
                'label' => 'Category',
                'value_options' => $categoryType,
            ],
        ]);
    }

    public function init()
    {
        parent::init();
        $this->setObject(new ProductFormData());
        $this->setHydrator(new ObjectPropertyHydrator());

        $this->add([
            'name' => 'title',
            'options' => [
                'label' => 'Title'
            ],
            'attributes' => [
                'id' => 'prodTitle',
            ],
            'type' => Text::class,
        ]);

        $this->add([
            'name' => 'description',
            'options' => [
                'label' => 'Description'
            ],
            'attributes' => [
                'id' => 'prodDescription',
                'rows'=> 5,
            ],
            'type' => Textarea::class,
        ]);

        $this->add([
            'name' => 'img',
            'options' => [
                'label' => 'Image Name'
            ],
            'attributes' => [
                'id' => 'prodImg',
            ],
            'type' => Text::class,
        ]);

        $this->add([
            'name' => 'price',
            'options' => [
                'label' => 'Price'
            ],
            'attributes' => [
                'id' => 'prodPrice',
            ],
            'type' => Text::class,
        ]);

        $this->add([
            'name' => 'status',
            'type' => 'select',
            'options' => [
                'label' => 'Product Status',
                'value_options' => [
                    ['value' => Product::STATUS_AVAILABLE, 'label' => Product::STATUS_AVAILABLE],
                    ['value' => Product::STATUS_UNAVAILABLE, 'label' => Product::STATUS_UNAVAILABLE]
                ]
            ],
        ], ['priority' => -30]);


   }

    /**
     * @return null|InputFilter|InputFilterInterface
     */
    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }
}