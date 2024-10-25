<?php

namespace App\Tests\Controller\Menu;

use App\DataFixtures\tests\ActiveCategoryFixtures;
use App\DataFixtures\tests\CategoryFixtures;
use App\DataFixtures\tests\ProductFixtures;
use App\DataFixtures\tests\StoreFixtures;
use App\DataFixtures\tests\UserFixtures;
use App\Entity\Product;
use App\Entity\Store;
use App\Repository\ProductRepository;
use App\Repository\StoreRepository;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MenuControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @var AbstractDatabaseTool
     */
    protected AbstractDatabaseTool $databaseTool;
    private KernelBrowser $client;
    private ProductRepository $productRepository;
    private StoreRepository $storeRepository;
    private string $path = '/menu';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->productRepository = static::getContainer()->get('doctrine')->getRepository(Product::class);
        $this->storeRepository = static::getContainer()->get('doctrine')->getRepository(Store::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function test_menu_is_accessible(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            StoreFixtures::class,
            CategoryFixtures::class,
            ProductFixtures::class,]);

        $store = $this->storeRepository->findAll()[0];
        $menu = $this->productRepository->findByStore($store);

        $crawler = $this->client->request('GET',  $this->path);

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', $store->getName());
        $this->assertStringContainsString($menu[0]->getName(), $crawler->text());
        $this->assertStringContainsString($menu[1]->getPriceHome(), $crawler->text());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
