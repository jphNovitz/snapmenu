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
        $users = $manager->getRepository(User::class)->findAll();

        $store = new Store();
        $store->setName('Fake Store');
        $store->setDescription('Lorem description');
        $store->setStreetName('street lorem');
        $store->setHouseNumber('75');
        $store->setPostCode('9999');
        $store->setCity('City lipsum');
        $store->setPhoneNumber('123456');
        $store->setEmail('store@lipsum.com');
        $manager->persist($store);

//        $store = new Store();
//        $store->setName('Fake Simple Store');
//        $store->setDescription('Simple description');
//        $store->setStreetName('street simple');
//        $store->setHouseNumber('57');
//        $store->setPostCode('5775');
//        $store->setCity('City Simple');
//        $store->setPhoneNumber('12345675');
//        $store->setEmail('simple@exempl.es');
//        $store->setOwner($users[1]);
//
//        $manager->persist($store);

        $manager->flush();
    }
}
