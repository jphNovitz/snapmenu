<?php

namespace App\DataFixtures\tests;

use App\Entity\ActiveCategory;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActiveCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findAll()[0];
        $categories = $manager->getRepository(Category::class)->findAll();

        $active = new ActiveCategory();
        $active->setCategory($categories[0]);
        $active->setStore($user->getStore());
        $manager->persist($active);

        $active = new ActiveCategory();
        $active->setCategory($categories[1]);
        $active->setStore($user->getStore());
        $manager->persist($active);

        $manager->flush();
    }
}
