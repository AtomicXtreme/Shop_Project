<?php

namespace Frontend\Product\Repository;

use Frontend\App\Repository\AbstractRepository;
use Frontend\Product\Entity\Order;

class OrderRepository extends AbstractRepository
{
    /**
     * Get all orders from DB
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return float|int|mixed|string
     */
    public function getOrders(
        int $offset = 0,
        int $limit = 30,
        string $sort = 'created',
        string $order = 'desc'
    ) {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('orders')
            ->from(Order::class, 'orders');
        $qb->setFirstResult($offset)->setMaxResults($limit)->orderBy('orders.' . $sort, $order);
        return $qb->getQuery()->useQueryCache(true)->getResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function countOrders()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(orders)')->from(Order::class, 'orders');

        return $qb->getQuery()->useQueryCache(true)->getSingleScalarResult();
    }
}