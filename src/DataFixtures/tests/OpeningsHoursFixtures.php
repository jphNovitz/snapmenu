<?php

namespace App\DataFixtures\tests;

use App\Entity\Category;
use App\Entity\OpeningHours;
use App\Entity\Store;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OpeningsHoursFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $store = $manager->getRepository(Store::class)->findOneBy(['id' => 1]);
        $opening = new OpeningHours();
        $opening->setDayOfWeek(1);
        $opening->setOpenTime(new \DateTimeImmutable('08:00:00'));
        $opening->setCloseTime(new \DateTimeImmutable('12:00:00'));
        $opening->setStore($store);

        $manager->persist($opening);
        $manager->flush();
    }
}
