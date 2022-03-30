<?php

namespace Frontend\Product\Service;


use Frontend\Product\Repository\MessageRepository;

/**
 * Class CategoryService
 * @package Frontend\Product\Service
 *
 * @Service()
 */
interface MessageServiceInterface
{
    public function getRepository(): MessageRepository;
}