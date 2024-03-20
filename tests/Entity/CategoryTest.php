<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function test_category_entity(): void
    {
        $category = new Category();

        $category->setName('Lorem');

        $this->assertEquals('Lorem', $category->getName());
    }
}
