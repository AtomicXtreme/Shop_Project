<?php

namespace Frontend\Product\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Frontend\App\Common\AbstractEntity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Frontend\User\Entity\User;

/**
 * Class Order
 * @package Frontend\Frontend\Order\Entity
 * @ORM\Entity(repositoryClass="Frontend\Product\Repository\OrderRepository")
 * @ORM\Table(name="user_order")
 * @ORM\HasLifecycleCallbacks
 * @package Frontend\Product\Entity
 */
class Order extends AbstractEntity
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';

    /**
     * @ORM\Column(name="status", type="string")
     * @var string
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="Frontend\User\Entity\User")
     * @ORM\JoinColumn(name="userUuid", referencedColumnName="uuid", nullable=false)
     * @var User $userUuid
     */
    protected $userUuid;

    /**
     * @ORM\OneToMany(targetEntity="Frontend\Product\Entity\Stock" , mappedBy="order")
     * @var ArrayCollection $stocks
     */
    protected $stocks;

    /**
     * Order constructor.
     * @param string $userUuid
     * @param string $status
     */

    public function __construct(
        User $userUuid,
        string $status = self::STATUS_PENDING


    ) {
        parent::__construct();

        $this->stocks = new ArrayCollection();
        $this->userUuid = $userUuid;
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
     * @return User
     */
    public function getUserUuid()
    {
        return $this->userUuid;
    }

    /**
     * @param User $userUuid
     */
    public function setUserUuid($userUuid): void
    {
        $this->userUuid = $userUuid;
    }

    /**
     * @return ArrayCollection
     */
    public function getStocks()
    {
        return $this->stocks;
    }

    /**
     * @param ArrayCollection $stocks
     */
    public function setStocks(ArrayCollection $stocks): void
    {
        $this->stocks = $stocks;
    }

    /**
     * Return an object of type Order
     * @param Stock $stock
     * @return $this
     */
    public function addStock(Stock $stock)
    {
        if(!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
        }
        return $this;
    }
}