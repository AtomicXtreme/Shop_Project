<?php

namespace Frontend\Product\Service;

use Frontend\Product\Entity\Category;
use Frontend\Product\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Dot\Mail\Exception\MailException;
use Dot\Mail\Service\MailService;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class CategoryService
 * @package Frontend\Product\Service
 *
 * @Service()
 */
class CategoryService implements CategoryServiceInterface
{
    /** @var CategoryRepository $categoryRepository */
    protected $categoryRepository;

    /** @var array $config */
    protected $config;

    /**
     * CategoryService constructor.
     * @param EntityManager $entityManager
     * @param array $config
     * @Inject({EntityManager::class, "config"})
     */
    public function __construct(
        EntityManager $entityManager,
        array $config = []
    ) {
        $this->categoryRepository = $entityManager->getRepository(Category::class);
        $this->config = $config;
    }

    /**
     * @return CategoryRepository
     */
    public function getRepository(): CategoryRepository
    {
        return $this->categoryRepository;
    }

}