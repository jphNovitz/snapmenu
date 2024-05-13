<?php

namespace App\Controller\Admin\Store;

use App\Entity\OpeningHours;
use App\Entity\Store;
use App\Form\OpeningHoursType;
use App\Repository\OpeningHoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/store/opening')]
class OpeningHoursController extends AbstractController
{

    #[Route('/', name: 'admin_opening_index', methods: ['GET'])]
    public function index(OpeningHoursRepository $openingHoursRepository): Response
    {
        return $this->render('admin/store/opening_hours/index.html.twig', [
            'opening_hours' => $openingHoursRepository->findBy(['store'=> $this->getUser()->getStore()]),
        ]);
    }

    #[Route('/new', name: 'admin_opening_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $openingHour = new OpeningHours();

        $form = $this->createForm(OpeningHoursType::class, $openingHour,);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $openingHour->setStore($this->getUser()->getStore());
            $entityManager->persist($openingHour);
            $entityManager->flush();

            return $this->redirectToRoute('admin_opening_index', [], Response::HTTP_FOUND);
        }

        return $this->render('admin/store/opening_hours/new.html.twig', [
            'opening_hour' => $openingHour,
            'form' => $form,
        ]);
    }

//    #[Route('/{id}', name: 'app_admin_store_opening_hours_show', methods: ['GET'])]
//    public function show(OpeningHours $openingHour): Response
//    {
//        return $this->render('admin/store/opening_hours/show.html.twig', [
//            'opening_hour' => $openingHour,
//        ]);
//    }

    #[Route('/{id}/edit', name: 'admin_opening_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OpeningHours $openingHour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OpeningHoursType::class, $openingHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_opening_index', [], Response::HTTP_FOUND);
        }

        return $this->render('admin/store/opening_hours/edit.html.twig', [
            'opening_hour' => $openingHour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_opening_delete', methods: ['POST'])]
    public function delete(Request $request, OpeningHours $openingHour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$openingHour->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($openingHour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_opening_index', [], Response::HTTP_SEE_OTHER);
    }
}
