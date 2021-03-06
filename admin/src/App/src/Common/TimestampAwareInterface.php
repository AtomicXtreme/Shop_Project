<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use DateTimeImmutable;

/**
 * Interface TimestampAwareInterface
 * @package Frontend\App\Common
 */
interface TimestampAwareInterface
{
    /**
     * @return DateTimeImmutable|null
     */
    public function getCreated(): ?DateTimeImmutable;

    /**
     * @return DateTimeImmutable|null
     */
    public function getUpdated(): ?DateTimeImmutable;

    /**
     * Update internal timestamps
     */
    public function touch(): self;
}
