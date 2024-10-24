<?php

namespace App\Controller\Contact;

use App\Entity\Message;
use App\Entity\Store;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/message')]
class MessageController extends AbstractController
{
//    #[Route('/', name: 'app_message_index', methods: ['GET'])]
//    public function index(MessageRepository $messageRepository): Response
//    {
//        if ($store = $this->getUser()->getStore())
//            $messages = $messageRepository->findBy(['owner'=> $store->getId()]);
//        else $messages = $messageRepository->findBy(['owner'=> null]);
//        return $this->render('/contact/message/index.html.twig', [
//            'messages' => $messageRepository->findAll(),
//        ]);
//    }

    #[Route('/envoyer/', name: 'app_message_send', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_redirect_after_login', [], Response::HTTP_FOUND);
        }

        return $this->render('contact/message/new.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

//    #[Route('/{id}', name: 'app_message_show', methods: ['GET'])]
//    public function show(Message $message): Response
//    {
//        return $this->render('message/show.html.twig', [
//            'message' => $message,
//        ]);
//    }

    #[Route('/{id}', name: 'app_message_delete', methods: ['POST'])]
    public function delete(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $message->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
