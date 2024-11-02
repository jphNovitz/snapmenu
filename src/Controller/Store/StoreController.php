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
    public function schedule(): Response
    {
        return $this->render('store/opening_hours.html.twig');
    }

    #[Route('/infos-contact-acces-menu', name: 'app_infos_contact')]
    public function infos(): Response
    {
        return $this->render('store/infos.html.twig');
    }

}
