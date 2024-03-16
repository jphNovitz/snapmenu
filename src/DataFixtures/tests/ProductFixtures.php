<?php

namespace App\DataFixtures\tests;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($loop = 1; $loop <= 3; $loop++) {
            $product = new Product();
            $product->setName('Lorem '.$loop);
            $product->setDescription('Lorem '.$loop.' Description');
            $product->setIngredients('ingredient_1, ingredient_2');
            $product->setPriceHome('3');
            $product->setPriceAway('4');
            $product->setVeggie(true);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
