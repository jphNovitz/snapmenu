<?php

namespace App\DataFixtures\tests;

use App\Entity\Category;
use App\Entity\Store;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StoreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findAll()[0];

        $store = new Store();
        $store->setName('Fake Store');
        $store->setDescription('Lorem description');
        $store->setStreetName('street lorem');
        $store->setHouseNumber('75');
        $store->setPostCode('9999');
        $store->setCity('City lipsum');
        $store->setPhoneNumber('123456');
        $store->setEmail('store@lipsum.com');
        $store->setOwner($user);

        $manager->persist($store);

        $manager->flush();
    }
}
