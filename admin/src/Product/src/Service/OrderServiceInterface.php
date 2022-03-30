<?php

namespace Frontend\Product\Service;


use Frontend\Product\Repository\OrderRepository;

/**
 * Class MessageService
 * @package Frontend\Contact\Service
 */
interface OrderServiceInterface
{
    /**
     * @return OrderRepository
     */
    public function getRepository(): OrderRepository;

    /**
     * Get orders from DB
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getOrders(int $offset = 0, int $limit = 30, string $sort = 'created', string $order = 'desc'): array;
}