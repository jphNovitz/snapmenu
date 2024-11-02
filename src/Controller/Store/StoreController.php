<?php

namespace App\Controller\Store;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StoreController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route('/heures-d-ouverture', name: 'app_opening_hours')]
    public function index(): Response
    {
        return $this->render('store/opening_hours.html.twig');
    }
}
