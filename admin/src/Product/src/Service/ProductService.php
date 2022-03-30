<?php

declare(strict_types=1);

namespace Frontend\Product\Service;

use Frontend\Product\Entity\Category;
use Frontend\Product\Entity\Product;
use Frontend\Product\Entity\Stock;
use Frontend\Product\FormData\ProductFormData;
use Frontend\Product\Repository\CategoryRepository;
use Frontend\Product\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Frontend\Product\Repository\StockRepository;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;

/**
 * Class ProductService
 * @package Frontend\Product\Service
 */
class ProductService implements ProductServiceInterface
{
    /** @var ProductRepository $repository */
    protected $repository;

    /** @var CategoryRepository $categoryRepository */
    protected $categoryRepository;

    /** @var StockRepository $stockRepository */
    protected $stockRepository;

    /** @var array $config */
    protected $config;

    /**
     * ProductService constructor.
     * @param EntityManager $entityManager
     * @param array $config
     * @Inject({EntityManager::class, "config"})
     */
    public function __construct(
        EntityManager             $entityManager,
        array                     $config = []
    )
    {
        $this->repository = $entityManager->getRepository(Product::class);
        $this->categoryRepository = $entityManager->getRepository(Category::class);
        $this->stockRepository = $entityManager->getRepository(Stock::class);
        $this->config = $config;
    }

    /**
     * @return ProductRepository
     */
    public function getRepository(): ProductRepository
    {
        return $this->repository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getProducts(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ): array {
        $result = [
            'rows' => [],
            'total' => $this->getRepository()->countProducts($search)
        ];

        $dataArray = $this->getRepository()->getProducts($offset, $limit, $search, $sort, $order);

        /** @var Product $product */
        foreach ($dataArray as $product) {
            $result['rows'][] = [
                'title' => $product->getTitle(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'img' => $product->getImg(),
                'status' => $product->getStatus(),
                'created' => $product->getCreated()->format('d-m-Y H:i:s'),
                'updated' => $product->getUpdated()->format('d-m-Y H:i:s'),
                'uuid' => $product->getUuid()->toString(),
                'stock'=> count($this->stockRepository->getStockByProduct($product))
            ];
        }

        return $result;
    }

    /**
     * Function that update a product
     * @param Product $product
     * @param ProductFormData $data
     * @return Product
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateProduct(Product $product, ProductFormData $data): Product
    {


        if (!empty($data->title)) {
            $product->setTitle($data->title);
        }

        if (!empty($data->description)) {
            $product->setDescription($data->description);
        }

        if (!empty($data->img)) {
            $product->setImg($data->img);
        }

        if (!empty($data->price)) {
            $product->setPrice($data->price);
        }

        if (!empty($data->status)) {
            $product->setStatus($data->status);
        }

        /** @var Category $category */
        if (!empty($data->category)) {
            $category = $this->categoryRepository->find($data->category);
            $product->setCategory($category);
        }

        $this->repository->saveProduct($product);

        return $product;
    }

    /**
     * Return an array with all category types
     * @return array
     */
    public function getProductFormProcessedCategory(): array
    {
        $allCategory = [];
        $result = $this->categoryRepository->getAllCategory();

        if (!empty($result)) {
            /** @var Category $category */
            foreach ($result as $category) {
                $allCategory[$category->getUuid()->toString()] = $category->getTitle();
            }
        }

        return $allCategory;
    }

    /**
     * Function that create a new product
     * @param ProductFormData $data
     * @return Product
     */
    public function createProduct(ProductFormData $data): Product
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($data->category);
        if($category instanceof Category) {
            $product = new Product($category, $data->title, $data->description, $data->price, $data->img);
            $this->repository->saveProduct($product);
        }
        return $product;
    }
}