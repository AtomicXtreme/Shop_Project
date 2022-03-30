<?php

declare(strict_types=1);

namespace Frontend\Product\Service;

use Frontend\Product\Entity\Order;
use Frontend\Product\Entity\Stock;
use Frontend\Product\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;

/**
 * Class OrderService
 * @package Frontend\Product\Service
 */
class OrderService implements OrderServiceInterface
{

    /** @var OrderRepository $orderRepository */
    protected $orderRepository;

    /** @var array $config */
    protected $config;

    /**
     * OrderService constructor.
     * @param EntityManager $entityManager
     * @param array $config
     * @Inject({EntityManager::class, "config"})
     */
    public function __construct(
        EntityManager             $entityManager,
        array                     $config = []
    )
    {

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

    /**
     * Get orders from DB
     * @param int $offset
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getOrders(
        int $offset = 0,
        int $limit = 30,
        string $sort = 'created',
        string $order = 'desc'
    ): array {
        $result = [
            'rows' => [],
            'total' => $this->getRepository()->countOrders()
        ];
        $dataArray = $this->getRepository()->getOrders($offset, $limit, $sort, $order);

        /** @var Order $order */
        foreach ($dataArray as $order) {
            $array = [];
            $total = 0;
            /** @var Stock $stock */
            foreach ($order->getStocks() as $stock){
                $array[] = $stock->getProduct()->getTitle();
                $total += $stock->getProduct()->getPrice();
            }
            $result['rows'][] = [
                'userUuid'=> $order->getUserUuid()->getName(),
                'status'=> $order->getStatus(),
                'created'=> $order->getCreated()->format('d-m-Y H:i:s'),
                'product'=> implode("<br>", $array),
                'total' => $total
            ];
        }
        return $result;
    }
}