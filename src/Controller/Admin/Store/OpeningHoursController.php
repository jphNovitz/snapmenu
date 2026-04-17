<?php

namespace App\Controller\Admin\Store;

use App\Contract\OpeningHoursManagerInterface;
use App\Entity\OpeningHours;
use App\Form\OpeningHoursType;
use App\Repository\OpeningHoursRepository;
use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/store/opening')]
class OpeningHoursController extends AbstractController
{

    public function __construct(private OpeningHoursManagerInterface $openingHoursManager,
                                private OpeningHoursRepository       $openingHoursRepository,
                                private StoreRepository              $storeRepository,)
    {
    }

    #[Route('/', name: 'admin_opening_index', methods: ['GET'])]
    public function index(): Response
    {
        $store = $this->storeRepository->findOneBy([], ['id' => 'ASC']);

        return $this->render('admin/store/opening_hours/index.html.twig', [
            'opening_hours' => $store
                ? $this->openingHoursRepository->findBy(['store' => $store])
                : [],
        ]);
    }

    #[Route('/new', name: 'admin_opening_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $openingHour = new OpeningHours();

        $form = $this->createForm(OpeningHoursType::class, $openingHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->openingHoursManager->create($openingHour);

            return $this->redirectToRoute('admin_opening_index', [], Response::HTTP_FOUND);
        }

        return $this->render('admin/store/opening_hours/new.html.twig', [
            'opening_hour' => $openingHour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_opening_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OpeningHours $openingHour): Response
    {
        $form = $this->createForm(OpeningHoursType::class, $openingHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->openingHoursManager->update($openingHour);

            return $this->redirectToRoute('admin_opening_index', [], Response::HTTP_FOUND);
        }

        return $this->render('admin/store/opening_hours/edit.html.twig', [
            'opening_hour' => $openingHour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_opening_delete', methods: ['POST'])]
    public function delete(Request $request, OpeningHours $openingHour): Response
    {
        if ($this->isCsrfTokenValid('delete' . $openingHour->getId(), $request->getPayload()->get('_token'))) {
            $this->openingHoursManager->delete($openingHour);
        }

        return $this->redirectToRoute('admin_opening_index', [], Response::HTTP_SEE_OTHER);
    }
}
