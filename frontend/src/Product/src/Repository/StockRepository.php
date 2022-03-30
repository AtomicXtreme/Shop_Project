<?php

namespace Frontend\Product\Repository;

use Doctrine\ORM;
use Doctrine\ORM\EntityRepository;
use Frontend\Product\Entity\Product;
use Frontend\Product\Entity\Stock;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;

class StockRepository extends  EntityRepository
{
    /**
     * Get all stock from DB.
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
     * Get stock of a specific product.
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
            ->setParameter('status',Stock::STATUS_AVAILABLE)
            ->setParameter('productUuid',$productID->getUuid(),UuidBinaryOrderedTimeType::NAME);
        return $qb->getQuery()->useQueryCache(true)->getResult();
    }
}
