<?php

namespace Frontend\Product\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\Mail\Exception\MailException;
use Dot\Mail\Service\MailService;
use Frontend\Product\Entity\Product;
use Frontend\Product\Entity\Stock;
use Frontend\Product\Form\StockForm;
use Frontend\Product\Repository\ProductRepository;
use Frontend\Product\Repository\StockRepository;
use Mezzio\Template\TemplateRendererInterface;

/**
 * StockService class
 * @package Frontend\Product\Service
 */
class StockService implements StockServiceInterface
{
    /** @var StockRepository $stockRepository */
    protected $stockRepository;

    /** @var ProductRepository $repository */
    protected $repository;

    /** @var array $config */
    protected $config;

    /**
     * StockService constructor.
     * @param EntityManager $entityManager
     * @param array $config
     * @Inject({EntityManager::class, "config"})
     */
    public function __construct(
        EntityManager $entityManager,
        array $config = []
    ) {
        $this->stockRepository = $entityManager->getRepository(Stock::class);
        $this->repository = $entityManager->getRepository(Product::class);
        $this->config = $config;
    }

    /**
     * @return StockRepository
     */
    public function getRepository(): StockRepository
    {
        return $this->stockRepository;
    }

    /**
     * Function that add stock for a specific product
     * @param Product $product
     * @param int $nr
     * @return void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createStock(Product $product,int $nr)
    {

        for ($i=1;$i<=$nr;$i++) {
            $stock = new Stock($product);
            $this->stockRepository->saveStock($stock);
        }
    }
}