<?php

namespace App\Service;

use App\Contract\CategoryManagerInterface;
use App\Entity\Category;
use App\Repository\CategoryRepository;

final class CategoryManager implements CategoryManagerInterface
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function create(Category $category): void
    {
        $this->categoryRepository->save($category, true);
    }

    public function update(Category $category): void
    {
        $this->categoryRepository->save($category, true);
    }

    public function delete(Category $category): void
    {
        $this->categoryRepository->remove($category, true);
    }

    public function toggleActive(Category $category): void
    {
        $category->setIsActive(!$category->isActive());
        $this->categoryRepository->save($category, true);
    }
}