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
        $this->userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
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
//        $user = $this->userRepository->findOneBy(["email"=>"simple@exempl.es"]);
//        $this->client->loginUser($user);

        $crawler = $this->client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Connexion');

//        dd($crawler->selectButton('Connexion')->form());
        $crawler = $this->client->submitForm('Connexion',[
            "_username" => "admin@exempl.es",
            "_password" => "password"
        ]);

        $crawler = $this->client->request('GET', '/admin');
        $this->assertResponseIsSuccessful();
//        $this->assertResponseRedirects("admin/");
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
