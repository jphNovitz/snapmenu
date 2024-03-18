<?php

namespace App\Tests;

use App\DataFixtures\tests\UserFixtures;
use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RegistrationControllerTest extends WebTestCase
{

    use RefreshDatabaseTrait;
    private KernelBrowser $client;
    private mixed $databaseTool;
    private $userRepository;
    private ContainerInterface $container;
    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $container = static::getContainer();
        $this->userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $this->databaseTool = $container->get(DatabaseToolCollection::class)->get();
        $this->container = $container;

    }
    public function test_registration_page_is_accessible(): void
    {

        $this->client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', "Inscription");
    }

    public function test_new_user_can_register()
    {
        $userRepository = $this->container->get(UserRepository::class);

        $form = $this->client->request('GET', '/register')->selectButton("Je m'enregistre")->form();

        $form['registration_form[email]'] = 'test_register@exempl.es';
        $form['registration_form[plainPassword]'] = 'password';
        $form['registration_form[agreeTerms]'] = 1;

        $this->client->submit($form);

        $this->assertResponseRedirects(
            '/login',
            302,
            'The user has been created');

        $testUser = $userRepository->findOneByEmail('test_register@exempl.es');
        $this->assertEquals('test_register@exempl.es', $testUser->getEmail());
    }

    public function test_user_can_confirm_account()
    {
        $this->client->followRedirects(false);
        $this->databaseTool->loadFixtures([]);
        $userRepository = $this->container->get(UserRepository::class);

        $form = $this->client->request('GET', '/register')->selectButton("Je m'enregistre")->form();
        $datetime =   time();
        $form['registration_form[email]'] = $datetime.'@exempl.es';
//        $form['registration_form[email]'] = 'test_register@exempl.es';
        $form['registration_form[plainPassword]'] = 'password';
        $form['registration_form[agreeTerms]'] = 1;

        $this->client->submit($form);
        $test_user_id = $userRepository->findOneByEmail($datetime.'@exempl.es')->getId();
//        $test_user_id = $userRepository->findOneByEmail('test_register@exempl.es')->getId();
//dd($this->userRepository->findAll());
        $this->assertEmailCount(1);
        $email = $this->getMailerMessage(0);
        $this->assertEmailHeaderSame($email, 'To', $datetime.'@exempl.es');
//        $this->assertEmailHeaderSame($email, 'To', 'test_register@exempl.es');

        $link = explode('"', $email->getHtmlBody())[1];
        $this->client->request('GET', $link);
        $this->assertResponseRedirects("/");
    }


    public function test_redirect_to_register_page_if_not_id_passed()
    {
        $this->client->request('GET', '/verify/email');
        $this->assertResponseRedirects('/register');
    }

    public function test_redirect_to_register_if_user_not_exist()
    {


        $this->client->request('GET', '/verify/email?id=999');
        $this->assertResponseRedirects('/register');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
