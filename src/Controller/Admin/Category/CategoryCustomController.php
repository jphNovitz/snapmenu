<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\ManageActiveCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/category')]
class CategoryCustomController extends AbstractController
{

    #[Route('/custom/new', name: 'admin_category_custom_new', methods: ['GET', 'POST'])]
    public function newCustom(Request $request, EntityManagerInterface $entityManager, ManageActiveCategory $manageActiveCategory): Response
    {
        $category = new Category();
        $category->setType('custom');
        $form = $this->createForm(CategoryType::class, $category, [
            'row_order_initial_value' => 5,
            'is_active' => true
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            if ($form->get('isActive')->getData()) { //if isActive
                $rowOrder = $form->get('rowOrder')->getData();
                $manageActiveCategory->createActiveCategory($category, $rowOrder, true);
            }
            return $this->redirectToRoute('admin_category_index', [], Response::HTTP_FOUND);
        }

        return $this->render('admin/category/new.html.twig', [
            'category_custom' => $category,
            'form' => $form,
        ]);
    }
}
