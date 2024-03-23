<?php

namespace App\Tests\Repository;

use App\DataFixtures\tests\CategoryFixtures;
use App\DataFixtures\tests\ProductFixtures;
use App\Entity\Category;
use App\Entity\CategoryCustom;
use App\Entity\CategoryDefault;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryRepositoryTest extends KernelTestCase
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


    public function test_category_repository(): void
    {
        $this->databaseTool->loadFixtures([CategoryFixtures::class]);

        $defaults = $this->entityManager
            ->getRepository(Category::class)
            ->findBy(['name'=> 'Lorem Default']);

        foreach ($defaults as $category) {
            $this->assertInstanceOf(CategoryDefault::class, $category);
        }

        $customs = $this->entityManager
            ->getRepository(Category::class)
            ->findBy(['name'=> 'Lorem Custom']);

        foreach ($customs as $category) {
            $this->assertInstanceOf(CategoryCustom::class, $category);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
    }
}
