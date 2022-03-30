<?php

namespace Frontend\Product\Service;


use Frontend\Product\Repository\OrderRepository;

/**
 * Class OrderService
 * @package Frontend\Product\Service
 *
 * @Service()
 */
interface OrderServiceInterface
{
    public function getRepository(): OrderRepository;
}