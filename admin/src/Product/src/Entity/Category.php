<?php

namespace Frontend\Product\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Frontend\App\Entity\AbstractEntity;

/**
 * Class Category
 * @package Frontend\Frontend\Product\Entity
 * @ORM\Entity(repositoryClass="Frontend\Product\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 * @ORM\HasLifecycleCallbacks
 * @package Frontend\Product\Entity
 */
class Category extends AbstractEntity
{
    public const STATUS_AVAILABLE = 'available';
    public const STATUS_UNAVAILABLE = 'unavailable';

    /**
     * @ORM\Column(name="title", type="string", length=50)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(name="status", type="text")
     * @var string
     */
    protected $status;

    /** Category constructor.
     * @param string $title
     * @param string $status
     */
    public function __construct(
        string $title,
        string $status = self::STATUS_UNAVAILABLE

    ) {
        parent::__construct();

        $this->title = $title;
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
}