<?php

namespace Frontend\Product\Service;

use Frontend\Product\Entity\Message;
use Frontend\Product\Repository\MessageRepository;
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
class MessageService implements MessageServiceInterface
{
    /** @var MessageRepository $messageRepository */
    protected $messageRepository;

    /** @var MailService $mailService */
    protected $mailService;

    /** @var TemplateRendererInterface $templateRenderer */
    protected $templateRenderer;

    /** @var array $config */
    protected $config;

    /**
     * MessageService constructor.
     * @param EntityManager $entityManager
     * @param MailService $mailService
     * @param TemplateRendererInterface $templateRenderer
     * @param array $config
     *
     * @Inject({EntityManager::class, MailService::class, TemplateRendererInterface::class, "config"})
     */
    public function __construct(
        EntityManager $entityManager,
        MailService $mailService,
        TemplateRendererInterface $templateRenderer,
        array $config = []
    ) {
        $this->messageRepository = $entityManager->getRepository(Message::class);
        $this->mailService = $mailService;
        $this->templateRenderer = $templateRenderer;
        $this->config = $config;
    }

    /**
     * @return MessageRepository
     */
    public function getRepository(): MessageRepository
    {
        return $this->messageRepository;
    }

}