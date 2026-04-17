<?php

namespace App\Controller\Admin\Store;

use App\Contract\StoreManagerInterface;
use App\Entity\Store;
use App\Form\StoreType;
use App\Mapper\StoreMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/store')]
class StoreController extends AbstractController
{
    public function __construct(private StoreMapper              $storeMapper,
                                private readonly StoreManagerInterface $storeManager)
    {
    }

    #[Route('/new', name: 'admin_store_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $user = $this->getUser();

        if ($user->getStore()) {
            return $this->redirectToRoute('admin_store_show', []);
        }


        $store = new Store();
        $form = $this->createForm(StoreType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $store->setOwner($user);
            $this->storeManager->create($store);

            return $this->redirectToRoute('admin_store_show', [], Response::HTTP_FOUND);
        }

        return $this->render('admin/store/store/new.html.twig', [
            'store' => $store,
            'form' => $form->createView(),
        ]);
    }

    #[Route('', name: 'admin_store_show', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('admin/store/store/show.html.twig');
    }

    #[Route('/{id}/edit', name: 'admin_store_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Store $store): Response
    {
        $storeDto = $this->storeMapper->toDto($store);

        $form = $this->createForm(StoreType::class, $storeDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $store = $this->storeMapper->updateEntity($store, $storeDto);
            $this->storeManager->update($store);

            return $this->redirectToRoute('admin_store_show', [], Response::HTTP_FOUND);
        }

        return $this->render('admin/store/store/edit.html.twig', [
            'store' => $store,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_store_delete', methods: ['POST'])]
    public function delete(Request $request, Store $store): Response
    {
        if ($this->isCsrfTokenValid('delete' . $store->getId(), $request->getPayload()->get('_token'))) {
            $this->storeManager->delete($store);
        }

        return $this->redirectToRoute('admin_default', [], Response::HTTP_SEE_OTHER);
    }
}
