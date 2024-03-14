<?php

namespace App\Tests\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
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
        $this->userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
    }

    public function test_admin_can_access_admin_default(): void
    {
        $admin_user = $this->userRepository->findOneBy(["email" => "admin@exempl.es"]);
        $this->client->loginUser($admin_user);
        $this->client->request('GET', '/admin/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello DefaultController!');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
