<?php

namespace App\Contract;

use App\Entity\Product;

interface ProductManagerInterface
{
    public function create(Product $product): void;

    public function update(Product $product): void;

    public function delete(Product $product): void;

}

