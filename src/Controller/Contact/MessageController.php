<?php

namespace App\Controller\Contact;

use App\Contract\MessageManagerInterface;
use App\Entity\Message;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/message')]
class MessageController extends AbstractController
{
    public function __construct(private MessageManagerInterface $messageManager){}


    #[Route('/envoyer/', name: 'app_message_send', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->messageManager->create($message);

            return $this->redirectToRoute('app_default', [], Response::HTTP_FOUND);
        }

        return $this->render('contact/message/new.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_delete', methods: ['POST'])]
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete' . $message->getId(), $request->getPayload()->getString('_token'))) {
            $this->messageManager->delete($message);
        }

        return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
