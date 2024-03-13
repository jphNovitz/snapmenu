<?php

namespace App\DataFixtures\tests;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
         $user = new User();
         $user->setEmail("admin@exempl.es");
         $user->setPassword($this->hasher->hashPassword($user, 'password'));
         $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
         $user->setIsVerified(true);
         $manager->persist($user);

         $user = new User();
         $user->setEmail("simple@exempl.es");
         $user->setPassword($this->hasher->hashPassword($user, 'password'));
         $user->setRoles(['ROLE_USER']);
         $user->setIsVerified(true);
         $manager->persist($user);

        $manager->flush();
    }
}
