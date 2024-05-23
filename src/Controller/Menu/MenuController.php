<?php

namespace App\Controller\Menu;

use App\Entity\Store;
use App\Repository\ActiveCategoryRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{
    public function __construct(private ActiveCategoryRepository $activeCategoryRepository)
    {}
    #[Route('/page/{slug}', name: 'app_menu')]
    public function index(Store $store): Response
    {
        $menu = $this->activeCategoryRepository->findMenu($store);

        return $this->render('menu/index.html.twig', [
            'store' => $store,
            'menu' => $menu,
        ]);
    }
}
