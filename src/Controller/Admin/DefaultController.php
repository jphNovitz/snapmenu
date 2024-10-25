<?php

namespace App\Controller\Admin;

use App\Repository\ActiveCategoryRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/admin/', name: 'admin_default')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $menu = $categoryRepository->findMenu();
        return $this->render('admin/home/index.html.twig', [
            'menu' => $menu,
        ]);
    }
}
