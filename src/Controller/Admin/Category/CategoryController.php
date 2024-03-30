<?php

namespace App\Controller\Admin\Category;

use App\Entity\ActiveCategory;
use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function PHPUnit\Framework\isInstanceOf;

#[Route('/admin/category')]
class CategoryController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'admin_category_index', methods: ['GET'])]
    public function index(): Response
    {
        $activeIds = $this->entityManager
            ->getRepository(ActiveCategory::class)
            ->findids($this->getUser()
                ->getStore());

        $categoryDefaults = $this->entityManager
            ->getRepository(Category::class)
            ->findBy(['type' => 'default']);


        $categoryCustoms = $this->entityManager
            ->getRepository(Category::class)
            ->findCategories($this->getUser(), 'custom');

        return $this->render('admin/category/index.html.twig', [
            'category_defaults' => $categoryDefaults,
            'category_customs' => $categoryCustoms,
            'active_ids' => $activeIds
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_index', [], Response::HTTP_FOUND);
        }

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_category_index', [], Response::HTTP_FOUND);
    }

    #[Route('/{id}/activate', name: 'admin_category_activate', methods: ['GET', 'POST'])]
    public function activate(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
//        if ($this->isCsrfTokenValid('activate' . $category->getId(), $request->request->get('_token'))) {
        $activeCategory = $entityManager->getRepository(ActiveCategory::class)
            ->findOneBy(['category' => $category, 'store' => $this->getUser()->getStore()]);

//            dd(!$activeCategory);

        if (!$activeCategory) {
            $activeCategory = new ActiveCategory();
            $activeCategory->setCategory($category);
            $activeCategory->setStore($this->getUser()->getStore());
            $entityManager->persist($activeCategory);
        } else {
            $entityManager->remove($activeCategory);
        }
        $entityManager->flush();
//        }

        return $this->redirectToRoute('admin_category_index', [], Response::HTTP_FOUND);
    }

}
