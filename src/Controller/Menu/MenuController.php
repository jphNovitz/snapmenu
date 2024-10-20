<?php

namespace App\Controller\Menu;

use App\Mapper\StoreMapper;
use App\Repository\CategoryRepository;
use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    #[Route('/menu', name: 'app_menu')]
    public function index(): Response
    {
        $menu = $this->categoryRepository->findMenu();
        return $this->render('menu/index.html.twig', [
            'menu' => $menu
        ]);
    }
}
