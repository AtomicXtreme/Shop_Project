<?php

namespace Frontend\Product\Service;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Dot\Mail\Exception\MailException;
use Dot\Mail\Service\MailService;
use Frontend\Product\Entity\Order;
use Frontend\Product\Repository\OrderRepository;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class OrderService
 * @package Frontend\Product\Service
 *
 * @Service()
 */
class OrderService implements OrderServiceInterface
{
    /** @var OrderRepository $orderRepository */
    protected $orderRepository;

    /** @var array $config */
    protected $config;

    /**
     * MessageService constructor.
     * @param EntityManager $entityManager
     * @param array $config
     *
     * @Inject({EntityManager::class, "config"})
     */
    public function __construct(
        EntityManager $entityManager,
        array $config = []
    ) {
        $this->orderRepository = $entityManager->getRepository(Order::class);
        $this->config = $config;
    }

    /**
     * @return OrderRepository
     */
    public function getRepository(): OrderRepository
    {
        return $this->orderRepository;
    }

}