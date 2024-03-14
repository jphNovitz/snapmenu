<?php

namespace App\Tests;

use App\DataFixtures\tests\UserFixtures;
use App\Entity\User;
use App\Repository\UserRepository;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

class LoginControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @var AbstractDatabaseTool
     */
    protected AbstractDatabaseTool $databaseTool;

    private KernelBrowser $client;
    private UserRepository $userRepository;
    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function test_login_page_is_accessible(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    public function test_user_can_login(): void
    {

        $this->databaseTool->loadFixtures([UserFixtures::class]);

        $this->client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Connexion');

        $this->client->submitForm('Connexion',[
            "_username" => "admin@exempl.es",
            "_password" => "password"
        ]);

        $this->assertResponseRedirects('/admin/');

        $this->client->request('GET', '/admin/');
        $this->assertResponseIsSuccessful();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
