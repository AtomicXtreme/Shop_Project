<?php

namespace Frontend\Product\Service;

use Frontend\Product\Entity\Stock;
use Frontend\Product\Repository\StockRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Dot\Mail\Exception\MailException;
use Dot\Mail\Service\MailService;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class CategoryService
 * @package Frontend\Product\Service
 *
 * @Service()
 */
class StockService implements StockServiceInterface
{
    /** @var StockRepository $stockRepository */
    protected $stockRepository;

    /** @var array $config */
    protected $config;

    /**
     * StockService constructor.
     * @param EntityManager $entityManager
     * @param array $config
     *
     * @Inject({EntityManager::class, "config"})
     */
    public function __construct(
        EntityManager $entityManager,
        array $config = []
    ) {
        $this->stockRepository = $entityManager->getRepository(Stock::class);
        $this->config = $config;
    }

    /**
     * @return StockRepository
     */
    public function getRepository(): StockRepository
    {
        return $this->stockRepository;
    }
}
