<?php

namespace Frontend\Product\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Frontend\App\Common\AbstractEntity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @package Frontend\Frontend\Product\Entity
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
     * @ORM\OneToMany(targetEntity="Frontend\Product\Entity\Stock" , mappedBy="product")
     * @var ArrayCollection $stocks
     */
    protected $stocks;

    /**
     * Product constructor.
     * @param string $title
     * @param string $description
     * @param string $price
     * @param string $status
     * @param string $img
     */
    public function __construct(
        string $title,
        string $description,
        string $price,
        Category $category,
        string $img,
        string $status = self::STATUS_UNAVAILABLE


    ) {
        parent::__construct();

        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->category=$category;
        $this->img = $img;
        $this->status = $status;
        $this->stocks = new ArrayCollection();


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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
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

    /**
     * Verify how many products are in stock and return exactly how many we need.
     * @param int $nr
     * @return array|mixed[]|\T[]|null
     */
    public function getStocks(int $nr)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('status',Stock::STATUS_AVAILABLE));
        if($this->stocks->matching($criteria)->count() >= $nr){
            return $this->stocks->matching($criteria)->slice(0,$nr);
        }
        return null;
    }

    /**
     * @param ArrayCollection $stocks
     */
    public function setStocks(ArrayCollection $stocks): void
    {
        $this->stocks = $stocks;
    }
}
