<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class CategoryDefaultTest extends TestCase
{
    public function test_category_default_entity(): void
    {

        $category = new Category();
        $category->setName('Lorem Category');
        $category->setType('default');

        $product = new Product();
        $product->setName('Lorem Product');
        $product->setDescription('Lorem Description');
        $product->setIngredients('ingredient_1, ingredient_2');
        $product->setVeggie(true);
        $product->setCategory($category);

        $this->assertEquals('Lorem Category', $category->getName());
        $this->assertEquals('Lorem Category', $product->getCategory()->getName());
    }
}
