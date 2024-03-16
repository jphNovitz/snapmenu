<?php

namespace App\Tests\Repository;

use App\DataFixtures\tests\ProductFixtures;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductRepositoryTest extends KernelTestCase
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


    public function test_product_repository(): void
    {
        $this->databaseTool->loadFixtures([ProductFixtures::class]);

        $products = $this->entityManager
            ->getRepository(Product::class)
            ->findBy(['priceHome'=> '3']);

        foreach ($products as $product) {
            $this->assertEquals('3', $product->getPriceHome());
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
//        $this->entityManager = null; // avoid memory leaks
    }
}
