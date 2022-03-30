<?php

namespace Frontend\Product\FormData;

use Frontend\Product\Entity\Category;
use Frontend\Product\Entity\Product;

/**
 * Class UserFormData
 * @package Frontend\Product\FormData
 */
class ProductFormData
{
    public ?string $title = null;
    public ?string $description = null;
    public ?string $img = null;
    public ?string $price = null;
    public ?string $status = null;
    public ?string $category = null;

    /**
     * @param Product $product
     * @return void
     */
    public function fromEntity(Product $product)
    {

        $this->category = $product->getCategory()->getUuid();
        $this->title = $product->getTitle();
        $this->description = $product->getDescription();
        $this->img = $product->getImg();
        $this->price = $product->getPrice();
        $this->status = $product->getStatus();

    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'img' => $this->img,
            'price' => $this->price,
            'status' => $this->status,
        ];
    }
}