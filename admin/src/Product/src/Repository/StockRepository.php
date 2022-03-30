<?php

namespace Frontend\Product\Repository;

use Frontend\App\Repository\AbstractRepository;
use Frontend\Product\Entity\Product;
use Frontend\Product\Entity\Stock;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;

class StockRepository extends AbstractRepository
{
    /**
     * Save stock object in DB
     * @param Stock $stock
     * @return void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveStock(Stock $stock)
    {
        $this->getEntityManager()->persist($stock);
        $this->getEntityManager()->flush();
    }

    /**
     * Get all stock obj from DB
     * @return float|int|mixed|string
     */
    public function getStock()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('stock')
            ->from(Stock::class, 'stock');
        return $qb->getQuery()->useQueryCache(true)->getResult();
    }

    /**
     * Get all stock for a specific product
     * @param Product $productID
     * @return float|int|mixed|string
     */
    public function getStockByProduct(
        Product $productID
    ) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('stock')
            ->from(Stock::class, 'stock')
            ->where('stock.product = :productUuid')
            ->andWhere('stock.status = :status')
            ->setParameter('status',Product::STATUS_AVAILABLE)
            ->setParameter('productUuid',$productID->getUuid(),UuidBinaryOrderedTimeType::NAME);
        return $qb->getQuery()->useQueryCache(true)->getResult();
    }
}