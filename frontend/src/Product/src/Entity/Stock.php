<?php

namespace Frontend\Product\Entity;

use Frontend\App\Common\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Stock
 * @package Frontend\Frontend\Product\Entity
 * @ORM\Entity(repositoryClass="Frontend\Product\Repository\StockRepository")
 * @ORM\Table(name="stock")
 * @ORM\HasLifecycleCallbacks
 * @package Frontend\Product\Entity
 */
class Stock extends AbstractEntity
{
    public const STATUS_AVAILABLE = 'available';
    public const STATUS_UNAVAILABLE = 'unavailable';

    /**
     * @ORM\Column(name="status", type="text")
     * @var string
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="Frontend\Product\Entity\Product")
     * @ORM\JoinColumn(name="productUuid", referencedColumnName="uuid", nullable=false)
     * @var Product $product
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="Frontend\Product\Entity\Order")
     * @ORM\JoinColumn(name="orderUuid", referencedColumnName="uuid" , nullable=false)
     * @var Order $order
     */
    protected $order;

    public function __construct(
        Product $product,
        Order $order,
        string $status = self::STATUS_UNAVAILABLE

    ) {
        parent::__construct();

        $this->product = $product;
        $this->order = $order;
        $this->status = $status;

    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }



}