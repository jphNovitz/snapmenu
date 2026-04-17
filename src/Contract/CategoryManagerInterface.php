<?php

namespace App\Contract;

use App\Entity\Category;

interface CategoryManagerInterface
{
    public function create(Category $category): void;
    public function update(Category $category): void;
    public function delete(Category $category): void;
    public function toggleActive(Category $category): void;
}

