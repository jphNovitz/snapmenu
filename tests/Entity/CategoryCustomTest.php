<?php

namespace App\Tests\Entity;

use App\Entity\CategoryCustom;
use App\Entity\CategoryDefault;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class CategoryCustomTest extends TestCase
{
    public function test_category_custom_entity(): void
    {
        $product = new Product();

        $product->setName('Lorem Product');
        $product->setDescription('Lorem Description');
        $product->setIngredients('ingredient_1, ingredient_2');
        $product->setVeggie(true);
        $category = new CategoryCustom();

        $category->setName('Lorem');
        $category->addProduct($product);

        $this->assertEquals('Lorem', $category->getName());
        $this->assertEquals('Lorem Product', $category->getProducts()[0]->getName());
    }
}
