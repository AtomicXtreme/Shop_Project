<?php

namespace Frontend\Product\Service;

use Frontend\Product\Repository\CategoryRepository;

interface CategoryServiceInterface
{
    public function getRepository(): CategoryRepository;
}