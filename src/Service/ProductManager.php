<?php

namespace App\Service;

use App\Contract\ProductManagerInterface;
use App\Entity\Product;
use App\Repository\ProductRepository;

final class ProductManager implements ProductManagerInterface
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function create(Product $product): void
    {
        $this->productRepository->save($product, true);
    }

    public function update(Product $product): void
    {
        $this->productRepository->save($product, true);
    }

    public function delete(Product $product): void
    {
        $this->productRepository->remove($product, true);
    }

}

