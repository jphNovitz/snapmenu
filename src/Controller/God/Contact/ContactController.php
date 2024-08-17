<?php

namespace App\Controller\God\Contact;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/god/contact')]
class ContactController extends AbstractController
{
    #[Route('/messages', name: 'god_message_index', methods: ['GET'])]
    public function index(MessageRepository $messageRepository): Response
    {
            $messages = $messageRepository->findBy(['owner' => null]);
            $templateToExtends = 'base.html.twig';

        return $this->render('/contact/message/index.html.twig', [
            'messages' => $messages,
            'template_to_extends' => $templateToExtends
        ]);
    }
}
