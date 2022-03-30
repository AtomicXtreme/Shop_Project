<?php

namespace Frontend\Product\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Frontend\App\Entity\AbstractEntity;

/**
 * Class Product
 * @package Frontend\Admin\Product\Entity
 * @ORM\Entity(repositoryClass="Frontend\Product\Repository\ProductRepository")
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks
 * @package Frontend\Product\Entity
 */
class Product extends AbstractEntity
{
    public const STATUS_AVAILABLE = 'available';
    public const STATUS_UNAVAILABLE = 'unavailable';

    /**
     * @ORM\Column(name="title", type="string", length=50)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(name="description", type="text")
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(name="price", type="float")
     * @var float
     */
    protected $price;

    /**
     * @ORM\Column(name="status", type="string")
     * @var string
     */
    protected $status;

    /**
     * @ORM\Column(name="img", type="string")
     * @var string
     */
    protected $img;

    /**
     * @ORM\OneToOne(targetEntity="Frontend\Product\Entity\Category")
     * @ORM\JoinColumn(name="categoryUuid", referencedColumnName="uuid", nullable=false)
     * @var Category $category
     */
    protected $category;

    /**
     * Product constructor.
     * @param string $title
     * @param string $description
     * @param string $price
     * @param string $status
     * @param string $img
     */
    public function __construct(
        Category $category,
        string $title,
        string $description,
        string $price,
        string $img,
        string $status = self::STATUS_UNAVAILABLE


    ) {
        parent::__construct();

        $this->category = $category;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->img = $img;
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
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
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
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }



}
