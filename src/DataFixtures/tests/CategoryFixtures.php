<?php

namespace App\DataFixtures\tests;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findAll()[0];

        $category = new Category();
        $category->setName('Lorem Default');
        $category->setisActive(true);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Lorem Custom');
        $category->setisActive(true);
        $manager->persist($category);

        $manager->flush();
    }
}
