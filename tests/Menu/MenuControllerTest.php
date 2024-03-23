<?php

namespace App\Tests\Menu;

use App\Entity\Product;
use App\Repository\ProductRepository;
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
    private string $path = '/menu';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->productRepository = static::getContainer()->get('doctrine')->getRepository(Product::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function test_menu_is_accessible(): void
    {
        $menu = $this->productRepository->findAll();
        $crawler = $this->client->request('GET', $this->path);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Menu');
        $this->assertStringContainsString($menu[0]->getName(), $crawler->text());
        $this->assertStringContainsString($menu[1]->getPriceHome(), $crawler->text());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
