<?php

namespace App\Controller;

use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Mapper\StoreMapper;

class DefaultController extends AbstractController
{
    public function __construct()
    {
    }
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }
    #[Route('/maintenance', name: 'app_fallback')]
    public function fallback(): Response
    {
        return $this->render('default/fallback.html.twig');
    }
}
