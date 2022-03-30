<?php

namespace Frontend\Product\Service;

use Frontend\Product\Entity\Product;
use Frontend\Product\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Dot\Mail\Exception\MailException;
use Dot\Mail\Service\MailService;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class ProductService
 * @package Frontend\Product\Service
 *
 * @Service()
 */
class ProductService implements ProductServiceInterface
{
    /** @var ProductRepository $productRepository */
    protected $productRepository;

    /** @var array $config */
    protected $config;

    /**
     * ProductService constructor.
     * @param EntityManager $entityManager
     * @param array $config
     *
     * @Inject({EntityManager::class, "config"})
     */
    public function __construct(
        EntityManager $entityManager,
        array $config = []
    ) {
        $this->productRepository = $entityManager->getRepository(Product::class);
        $this->config = $config;
    }

    /**
     * @return ProductRepository
     */
    public function getRepository(): ProductRepository
    {
        return $this->productRepository;
    }

    /**
     * Function to get all products from DB
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllProducts(
        int $offset = 0,
        int $limit = 20,
        string $sort = 'created',
        string $order = 'desc'
    ): array {

        $dataArray = $this->getRepository()->getAllProducts($offset, $limit, $sort, $order);
        return $dataArray;
    }
}
