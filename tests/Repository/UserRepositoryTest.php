<?php

namespace App\Tests\Repository;

use App\DataFixtures\tests\UserFixtures;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{

    private EntityManagerInterface $entityManager;
    private DatabaseToolCollection $databaseTools;
    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }


    public function test_user_repository(): void
    {
        $this->databaseTool->loadFixtures([UserFixtures::class]);

        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email'=> 'simple@exempl.es']);

            $this->assertEquals('simple@exempl.es', $user->getEmail());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
//        $this->entityManager = null; // avoid memory leaks
    }
}
