<?php

namespace Frontend\Product\Repository;

use Doctrine\ORM;
use Doctrine\ORM\EntityRepository;
use Frontend\Product\Entity\Category;
use Frontend\Product\Entity\Product;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;

class ProductRepository extends  EntityRepository
{
    /**
     * Insert product in DB
     * @param Product $product
     * @return void
     * @throws ORM\ORMException
     * @throws ORM\OptimisticLockException
     */
    public function saveProduct(Product $product)
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }

    /**
     * Get all products where status is available
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return float|int|mixed|string
     */
    public function getAllProducts(
        int $offset = 0,
        int $limit = 30,
        string $sort = 'created',
        string $order = 'desc'
    ) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('product')
            ->from(Product::class, 'product')
            ->where('product.status =:status')
            ->setParameter('status',Product::STATUS_AVAILABLE);
        $qb->setFirstResult($offset)->setMaxResults($limit)->orderBy('product.' . $sort, $order);

        return $qb->getQuery()->useQueryCache(true)->getResult();
    }

    /**
     * Get products only from specified category.
     * @param Category $category
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return float|int|mixed|string
     */
    public function getProductsByCategory(
        Category $category,
        int $offset = 0,
        int $limit = 30,
        string $sort = 'created',
        string $order = 'desc'

    ) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('product')
            ->from(Product::class, 'product')
            ->where('product.category =:categoryUuid')
            ->andWhere('product.status =:status')
            ->setParameter('status',Product::STATUS_AVAILABLE)
            ->setParameter('categoryUuid',$category->getUuid(),UuidBinaryOrderedTimeType::NAME);
        $qb->setFirstResult($offset)->setMaxResults($limit)->orderBy('product.' . $sort, $order);

        return $qb->getQuery()->useQueryCache(true)->getResult();
    }

    /**
     * Find products in DB by specified UUID.
     * @param string $uuid
     * @return Product|null
     * @throws ORM\NonUniqueResultException
     */
    public function findByUuid(string $uuid): ?Product
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('product')
            ->from(Product::class, 'product')
            ->where("product.uuid = :uuid")
            ->setParameter('uuid', $uuid, UuidBinaryOrderedTimeType::NAME)
            ->setMaxResults(1);
        return $qb->getQuery()->useQueryCache(true)->getOneOrNullResult();
    }
}