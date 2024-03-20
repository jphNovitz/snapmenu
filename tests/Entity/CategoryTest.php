<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Product;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class CategoryTest extends TestCase
{
    public function test_category_entity(): void
    {
        $product = new Product();

        $product->setName('Lorem Product');
        $product->setDescription('Lorem Description');
        $product->setIngredients('ingredient_1, ingredient_2');
        $product->setVeggie(true);

        $category = new Category();

        $category->setName('Lorem');
        $category->addProduct($product);

        $this->assertEquals('Lorem', $category->getName());
        $this->assertEquals('Lorem Product', $category->getProducts()[0]->getName());

        $category->removeProduct($product);
        $this->assertEquals(0, $category->getProducts()->count());
    }
}
