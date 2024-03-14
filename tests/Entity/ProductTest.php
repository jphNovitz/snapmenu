<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;

class ProductTest extends TestCase
{
    public function test_product(): void
    {
        $product = new Product();

        $product->setName('Lorem');
        $product->setDescription('Lorem Description');
        $product->setIngredients('ingredient_1, ingredient_2');
        $product->setVeggie(true);

        $this->assertEquals('Lorem', $product->getName());
        $this->assertEquals('Lorem Description', $product->getDescription());
        $this->assertStringContainsString('ingredient_1', $product->getIngredients());
        $this->assertStringContainsString('ingredient_2', $product->getIngredients());
        $this->assertTrue($product->isVeggie());
        $this->assertFalse($product->isHalal());
        $product->setHalal(true);
        $this->assertTrue($product->isHalal());
    }
}
