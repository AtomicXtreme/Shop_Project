<?php

namespace Frontend\Product\Repository;

use Doctrine\ORM;
use Doctrine\ORM\EntityRepository;
use Frontend\Product\Entity\Message;
use Frontend\Product\Entity\Product;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;

class MessageRepository extends  EntityRepository
{
    /**
     * Insert message in DB
     * @param Message $message
     * @return void
     * @throws ORM\ORMException
     * @throws ORM\OptimisticLockException
     */
    public function saveMessage(Message $message)
    {
        $this->getEntityManager()->persist($message);
        $this->getEntityManager()->flush();
    }

    /**
     * Get all messages from Db where status is available.
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return float|int|mixed|string
     */
    public function getAllMessages(
        int $offset = 0,
        int $limit = 30,
        string $sort = 'created',
        string $order = 'desc'
    ) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('message')
            ->from(Message::class, 'message')
            ->where('message.status =:status')
            ->setParameter('status',Message::STATUS_AVAILABLE);
        $qb->setFirstResult($offset)->setMaxResults($limit)->orderBy('message.' . $sort, $order);

        return $qb->getQuery()->useQueryCache(true)->getResult();
    }

    /**
     * Get all messages by specified product.
     * @param Product $productID
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return float|int|mixed|string
     */
    public function getAllMessagesByProduct(
        Product $productID,
        int $offset = 0,
        int $limit = 30,
        string $sort = 'created',
        string $order = 'desc'
    ) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('message')
            ->from(Message::class, 'message')
            ->where('message.status =:status')
            ->setParameter('status',Message::STATUS_AVAILABLE)
            ->andWhere('message.productID =:productUuid')
            ->setParameter('productUuid',$productID->getUuid(),UuidBinaryOrderedTimeType::NAME);
        $qb->setFirstResult($offset)->setMaxResults($limit)->orderBy('message.' . $sort, $order);

        return $qb->getQuery()->useQueryCache(true)->getResult();
    }
}