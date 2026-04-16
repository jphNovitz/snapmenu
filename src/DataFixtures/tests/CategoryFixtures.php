<?php

namespace App\DataFixtures\tests;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Lorem Ipsum');
        $category->setIsActive(true);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Lorem Dolor');
        $category->setIsActive(true);
        $manager->persist($category);

        $manager->flush();
    }
}
