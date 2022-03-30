<?php

namespace Frontend\Product\Entity;

use Frontend\App\Common\AbstractEntity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Frontend\User\Entity\UserDetail;

/**
 * Class Message
 * @package Frontend\Frontend\Product\Entity
 * @ORM\Entity(repositoryClass="Frontend\Product\Repository\MessageRepository")
 * @ORM\Table(name="message")
 * @ORM\HasLifecycleCallbacks
 * @package Frontend\Product\Entity
 */
class Message extends AbstractEntity
{
    public const STATUS_AVAILABLE = 'available';
    public const STATUS_UNAVAILABLE = 'unavailable';

    /**
     * @ORM\Column(name="title", type="text")
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(name="text", type="text")
     * @var string
     */
    protected $text;

    /**
     * @ORM\Column(name="status", type="text")
     * @var string
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="Frontend\User\Entity\UserDetail")
     * @ORM\JoinColumn(name="userUuid", referencedColumnName="uuid", nullable=false)
     * @var UserDetail $userDetail
     */
    protected $userDetail;

    /**
     * @ORM\OneToOne(targetEntity="Frontend\Product\Entity\Product")
     * @ORM\JoinColumn(name="productUuid", referencedColumnName="uuid", nullable=false)
     * @var Product $productID
     */
    protected $productID;

    /** Message constructor.
     * @param string $text
     * @param string $status
     */
    public function __construct(
        UserDetail $userDetail,
        Product $productID,
        string $title,
        string $text,
        string $status = self::STATUS_AVAILABLE

    ) {
        parent::__construct();

        $this->userDetail=$userDetail;
        $this->productID=$productID;
        $this->title=$title;
        $this->text = $text;
        $this->status = $status;

    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
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
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return UserDetail
     */
    public function getUserDetail(): UserDetail
    {
        return $this->userDetail;
    }

    /**
     * @param UserDetail $userDetail
     */
    public function setUserDetail(UserDetail $userDetail): void
    {
        $this->userDetail = $userDetail;
    }

    /**
     * @return Product
     */
    public function getProductID(): Product
    {
        return $this->productID;
    }

    /**
     * @param Product $productID
     */
    public function setProductID(Product $productID): void
    {
        $this->productID = $productID;
    }



}