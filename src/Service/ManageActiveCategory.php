<?php

namespace App\Service;

use App\Contract\ManageActiveCategoryInterface;
use App\Entity\ActiveCategory;
use App\Entity\Category;
use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;

class ManageActiveCategory implements ManageActiveCategoryInterface{

    public function __construct(private EntityManagerInterface $entityManager) {}
    public function createActiveCategory(Category $category, int $rowOrder, bool $flush = false): void
    {
        $activeCategory = new ActiveCategory();
        $activeCategory->setStore($category->getOwner());
        $activeCategory->setCategory($category);
        $activeCategory->setRowOrder($rowOrder);

        $this->entityManager->persist($activeCategory);
        if ($flush)
            $this->entityManager->flush();
    }
}