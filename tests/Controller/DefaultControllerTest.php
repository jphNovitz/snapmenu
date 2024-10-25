<?php

namespace App\Test\Controller;

use App\DataFixtures\tests\CategoryFixtures;
use App\DataFixtures\tests\OpeningsHoursFixtures;
use App\DataFixtures\tests\ProductFixtures;
use App\DataFixtures\tests\StoreFixtures;
use App\DataFixtures\tests\UserFixtures;
use App\Entity\Store;
use App\Repository\StoreRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private string $path = '/';
    private StoreRepository $storeRepository;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->storeRepository = static::getContainer()->get('doctrine')->getRepository(Store::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();

    }

    public function test_public_index(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            StoreFixtures::class,
            OpeningsHoursFixtures::class,
            CategoryFixtures::class,
            ProductFixtures::class]);

        $this->client->disableReboot();

        $store = $this->storeRepository->findAll()[0];

        $crawler = $this->client->request('GET', sprintf('%s', $this->path));
        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains($store->getName());
        self::assertStringContainsString("Voir le menu", $crawler->text());
        self::assertStringContainsString("Horaire", $crawler->text());
    }

   public function test_public_index_cta_primary(): void
   {
       $crawler = $this->client->request('GET', sprintf('%s', $this->path));
       self::assertResponseStatusCodeSame(200);
       self::assertStringContainsString("Voir le menu", $crawler->filter('a#cta-primary')->text());

       $link = $crawler->filter('a#cta-primary')->link();
       $crawler = $this->client->click($link);

       self::assertResponseStatusCodeSame(200);
       self::assertPageTitleContains('Menu');
       self::assertStringContainsString('Menu', $crawler->filter('h1')->text());
   }


}
