<?php

namespace App\Tests\Entity;

use App\Entity\CategoryDefault;
use PHPUnit\Framework\TestCase;

class CategoryDefaultTest extends TestCase
{
    public function test_category_default_entity(): void
    {
        $category = new CategoryDefault();

        $category->setName('Lorem');

        $this->assertEquals('Lorem', $category->getName());
    }
}
