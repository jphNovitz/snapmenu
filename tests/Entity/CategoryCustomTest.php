<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class CategoryCustomTest extends TestCase
{
    public function test_category_custom_entity(): void
    {

        $category = new Category();
        $category->setName('Lorem');
        $category->setType('custom');
//        $category->addProduct($product);

        $product = new Product();
        $product->setName('Lorem Product');
        $product->setDescription('Lorem Description');
        $product->setIngredients('ingredient_1, ingredient_2');
        $product->setVeggie(true);
        $product->setCategory($category);

        $this->assertEquals('Lorem', $category->getName());
        $this->assertEquals('Lorem', $product->getCategory()->getName());
    }
}
