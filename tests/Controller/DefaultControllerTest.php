<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private string $path = '/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function test_public_index(): void
    {
        $crawler = $this->client->request('GET', sprintf('%s', $this->path));
        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('| snapmenu.be');
        self::assertStringContainsString("Un QR code, tout le menu", $crawler->filter('h1')->text());
    }

   public function test_public_index_cta_primary(): void
   {
       $crawler = $this->client->request('GET', sprintf('%s', $this->path));
       self::assertResponseStatusCodeSame(200);
       self::assertStringContainsString("Je suis restaurateur", $crawler->filter('a#cta-primary')->text());
       $this->client->clickLink('Je suis restaurateur');
       self::assertResponseStatusCodeSame(200);
       self::assertPageTitleContains('Inscription');
   }

   public function test_public_index_cta_secondary(): void
   {
       $crawler = $this->client->request('GET', sprintf('%s', $this->path));
       self::assertResponseStatusCodeSame(200);
       self::assertStringContainsString("Voir les restaurants", $crawler->filter('a#cta-secondary')->text());
       $this->client->clickLink('Voir les restaurants');
       self::assertResponseStatusCodeSame(200);
       self::assertStringContainsString("Ces restaurateurs Snappent", $crawler->text());
   }

}
