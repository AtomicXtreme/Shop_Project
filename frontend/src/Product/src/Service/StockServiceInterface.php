<?php

namespace Frontend\Product\Service;


use Frontend\Product\Repository\StockRepository;

/**
 * Class CategoryService
 * @package Frontend\Product\Service
 *
 * @Service()
 */
interface StockServiceInterface
{
    public function getRepository(): StockRepository;
}