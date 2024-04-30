<?php

namespace App\Controller\Menu;

use App\Entity\Store;
use App\Repository\ActiveCategoryRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{

    #[Route('/{slug}/contact', name: 'app_contact')]
    public function index(Store $store): Response
    {
        return $this->render('contact/index.html.twig', [
            'store' => $store,
        ]);
    }
}
