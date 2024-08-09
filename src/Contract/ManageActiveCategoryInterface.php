<?php

namespace App\Contract;

use App\Entity\Category;

interface ManageActiveCategoryInterface
{
    public function createActiveCategory(Category $category, int $rowOrder, bool $flush = false);

}