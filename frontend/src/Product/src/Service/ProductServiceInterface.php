<?php

namespace Frontend\Product\Service;

use Frontend\Product\Repository\ProductRepository;

interface ProductServiceInterface
{
    public function getRepository(): ProductRepository;
}