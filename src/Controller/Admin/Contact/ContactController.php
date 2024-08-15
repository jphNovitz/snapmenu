<?php

namespace App\Controller\Admin\Contact;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/contact')]
class ContactController extends AbstractController
{
    private  $templateToExtends = 'admin/base.html.twig';
    #[Route('/messages', name: 'app_message_index', methods: ['GET'])]
    public function index(MessageRepository $messageRepository): Response
    {
        $messages = $messageRepository->findOrderedMessages($this->getUser()->getStore());
        $templateToExtends = 'admin/base.html.twig';
        return $this->render('/contact/message/index.html.twig', [
            'messages' => $messages,
            'template_to_extends' => $templateToExtends,
        ]);
    }

    #[Route('/{id}', name: 'app_message_show', methods: ['GET'])]
    public function show(Message $message): Response
    {
        return $this->render('contact/message/show.html.twig', [
            'message' => $message,
            'template_to_extends' => $this->templateToExtends,
        ]);
    }
}
