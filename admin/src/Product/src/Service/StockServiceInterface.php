<?php

namespace Frontend\Product\Service;

use Frontend\Product\Entity\Product;
use Frontend\Product\Repository\StockRepository;

interface StockServiceInterface
{
    public function getRepository(): StockRepository;

    public function createStock(Product $product, int $nr);
}