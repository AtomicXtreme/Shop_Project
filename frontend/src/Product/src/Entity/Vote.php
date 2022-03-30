<?php

namespace Frontend\Product\Entity;

use Frontend\App\Common\AbstractEntity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Vote
 * @package Frontend\Frontend\Product\Entity
 * @ORM\Entity(repositoryClass="Frontend\Product\Repository\VoteRepository")
 * @ORM\Table(name="vote")
 * @ORM\HasLifecycleCallbacks
 * @package Frontend\Product\Entity
 */
class Vote extends AbstractEntity
{
    public const TYPE_UPVOTE = 1;
    public const TYPE_DOWNVOTE = -1;
    public const TYPE_NEUTRAL = 0;
    /**
     * @ORM\Column(name="type", type="int")
     * @var int
     */
    protected $type;

    public function __construct(
        string $type = self::TYPE_NEUTRAL

    ) {
        parent::__construct();

        $this->type = $type;

    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return void
     */
    public function setStatus(int $type): void
    {
        $this->type = $type;
    }
}