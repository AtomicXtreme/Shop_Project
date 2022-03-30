<?php

namespace Frontend\Product\Repository;

use Frontend\Product\Entity\Order;
use Frontend\User\Entity\User;
use Doctrine\ORM;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;

class OrderRepository extends EntityRepository
{
    /**
     * Insert order in DB
     * @param Order $order
     * @return void
     * @throws ORM\ORMException
     * @throws ORM\OptimisticLockException
     */
    public function saveOrder(Order $order)
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }
}