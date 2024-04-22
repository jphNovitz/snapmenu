<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Entity\CategoryInStore;
use App\Form\CategoryInStoreType;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/category')]
class CategoryDefaultController extends AbstractController
{
    #[Route('/default/new', name: 'admin_category_default_new', methods: ['GET', 'POST'])]
    public function newDefault(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $category->setType('default');
//        $categoryInStore = new CategoryInStore();
//        $categoryInStore->setCategory($category);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_index', [], Response::HTTP_FOUND);
        }

        return $this->render('admin/category/new.html.twig', [
            'category_default' => $category,
            'form' => $form,
        ]);
    }


}
