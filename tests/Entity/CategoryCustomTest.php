<?php

namespace App\Tests\Entity;

use App\Entity\CategoryCustom;
use App\Entity\CategoryDefault;
use PHPUnit\Framework\TestCase;

class CategoryCustomTest extends TestCase
{
    public function test_category_custom_entity(): void
    {
        $category = new CategoryCustom();

        $category->setName('Lorem');

        $this->assertEquals('Lorem', $category->getName());
    }
}
