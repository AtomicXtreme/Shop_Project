<?php

declare(strict_types=1);

namespace Frontend\Product\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Frontend\App\Repository\AbstractRepository;
use Frontend\Product\Entity\Product;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Throwable;

/**
 * Class UserRepository
 * @package Frontend\User\Repository
 */
class ProductRepository extends AbstractRepository
{
    /**
     * Get all products from DB , and verify if search param is null or not , if not than it gets all products by
     * specified title
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return float|int|mixed|string
     */
    public function getProducts(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('product')
            ->from(Product::class, 'product');

        if (!is_null($search)) {
            $qb->where($qb->expr()->like('product.title', ':search'))
                ->setParameter('search', '%' . $search . '%');
        }

        $qb->setFirstResult($offset)->setMaxResults($limit)->orderBy('product.' . $sort, $order);

        return $qb->getQuery()->useQueryCache(true)->getResult();
    }

    /**
     * Search product in DB by UUID and returns the product object
     * @param string $uuid
     * @return Product|null
     * @throws NonUniqueResultException
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

    /**
     * Save product object inside DB
     * @param Product $product
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveProduct(Product $product)
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }

    /**
     *
     * @param string|null $search
     * @return float|int|mixed|string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countProducts(string $search = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(product)')->from(Product::class, 'product');

        if (!is_null($search)) {
            $qb->where($qb->expr()->like('product.title', ':search'))
                ->setParameter('search', '%' . $search . '%');
        }

        return $qb->getQuery()->useQueryCache(true)->getSingleScalarResult();
    }
}