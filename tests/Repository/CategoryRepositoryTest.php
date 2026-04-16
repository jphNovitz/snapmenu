<?php

namespace App\Tests\Repository;

use App\Entity\Allergen;
use App\DataFixtures\tests\CategoryFixtures;
use App\DataFixtures\tests\ProductFixtures;
use App\DataFixtures\tests\StoreFixtures;
use App\DataFixtures\tests\UserFixtures;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryRepositoryTest extends KernelTestCase
{

    private EntityManagerInterface $entityManager;
    private object $databaseTool;
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
        $this->databaseTool->loadFixtures([
                UserFixtures::class,
                StoreFixtures::class,
                CategoryFixtures::class,
                ProductFixtures::class]);

        $categories = $this->entityManager
            ->getRepository(Category::class)
            ->findBy(['name'=> 'Lorem Ipsum']);

        $this->assertNotEmpty($categories);
        $this->assertInstanceOf(Category::class, $categories[0]);
        $this->assertEquals('Lorem Ipsum', $categories[0]->getName());
        $this->assertTrue($categories[0]->isActive());
        $this->assertIsInt($categories[0]->getRowOrder());

        $product = $this->entityManager
            ->getRepository(Product::class)
            ->findOneBy(['name' => 'Lorem 1']);

        $allergen = new Allergen();
        $allergen->setName('gluten');
        $this->entityManager->persist($allergen);

        $product->addAllergen($allergen);
        $this->entityManager->flush();

        $menu = $this->entityManager
            ->getRepository(Category::class)
            ->findMenu();

        $this->assertNotEmpty($menu);
        $this->assertContainsOnlyInstancesOf(Category::class, $menu);
        $this->assertTrue($menu[0]->isActive());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
    }
}
