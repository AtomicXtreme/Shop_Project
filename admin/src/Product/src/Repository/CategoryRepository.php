<?php

namespace Frontend\Product\Repository;

use Doctrine\ORM\EntityRepository;
use Frontend\Product\Entity\Category;

class CategoryRepository extends  EntityRepository
{
    /**
     * Save category in DB
     * @param Category $category
     * @return void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveCategory(Category $category)
    {
        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();
    }

    /**
     * Get category by title
     * @param string $categoryType
     * @return float|int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCategory(string $categoryType)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('category')
            ->from(Category::class, 'category')
            ->where('category.title =:title');
        $qb->setParameter('title',$categoryType);
        return $qb->getQuery()->useQueryCache(true)->getOneOrNullResult();
    }

    /**
     * Get all category types from DB
     * @return float|int|mixed|string
     */
    public function getAllCategory()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('category')
            ->from(Category::class, 'category');
        return $qb->getQuery()->useQueryCache(true)->getResult();
    }
}