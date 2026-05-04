<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'menu' => $this->categoryRepository->findMenu(),
        ]);
    }
    #[Route('/maintenance', name: 'app_fallback')]
    public function fallback(): Response
    {
        return $this->render('default/fallback.html.twig');
    }

    #[Route('/mentions-legales', name: 'app_mentions_legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('default/mentions-legales.html.twig');
    }

    #[Route('/politique-de-confidentialite', name: 'app_politique_confidentialite')]
    public function politiqueConfidentialite(): Response
    {
        return $this->render('default/politique-confidentialite.html.twig');
    }
}
