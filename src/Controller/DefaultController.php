<?php

namespace App\Controller;

use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(StoreRepository $storeRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'stores' => $storeRepository->findList(),
        ]);
    }
}
