<?php

namespace App\Controller\Admin\Store;

use App\Entity\Store;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/store')]
class StoreController extends AbstractController
{
//    #[Route('/', name: 'admin_store_index', methods: ['GET'])]
//    public function index(StoreRepository $storeRepository): Response
//    {
//        return $this->render('admin/store/store/index.html.twig', [
//            'stores' => $storeRepository->findAll(),
//        ]);
//    }

    #[Route('/new', name: 'admin_store_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        
        if ($user->getStore()) {
            $storeId = $user->getStore()->getId();
            return $this->redirectToRoute('admin_store_show', ['id' => $storeId]);
        }


        $store = new Store();
        $form = $this->createForm(StoreType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $store->setOwner($user);
            $entityManager->persist($store);
            $entityManager->flush();

            return $this->redirectToRoute('admin_store_show', ['id' => $store->getId()], Response::HTTP_FOUND);
        }

        return $this->render('admin/store/store/new.html.twig', [
            'store' => $store,
            'form' => $form->createView(),
        ]);
    }

    #[Route('', name: 'admin_store_show', methods: ['GET'])]
    public function show(): Response
    {
        $store = $this->getUser()->getStore();

        return $this->render('admin/store/store/show.html.twig', [
            'store' => $store,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_store_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Store $store, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StoreType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_store_show', ['id' => $store->getId()], Response::HTTP_FOUND);
        }

        return $this->render('admin/store/store/edit.html.twig', [
            'store' => $store,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_store_delete', methods: ['POST'])]
    public function delete(Request $request, Store $store, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$store->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($store);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_default', [], Response::HTTP_SEE_OTHER);
    }
}
