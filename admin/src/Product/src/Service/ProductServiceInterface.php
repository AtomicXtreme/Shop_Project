<?php

namespace Frontend\Product\Service;


use Frontend\Product\Repository\ProductRepository;

/**
 * Class MessageService
 * @package Frontend\Contact\Service
 */
interface ProductServiceInterface
{
    /**
     * @return ProductRepository
     */
    public function getRepository(): ProductRepository;

    public function getProducts(int $offset = 0, int $limit = 30, string $sort = 'created', string $order = 'desc'): array;
}