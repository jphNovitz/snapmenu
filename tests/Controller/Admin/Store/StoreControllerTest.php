<?php

namespace App\Test\Controller;

use App\DataFixtures\tests\StoreFixtures;
use App\DataFixtures\tests\UserFixtures;
use App\Entity\Store;
use App\Entity\User;
use App\Repository\StoreRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Faker;

class StoreControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @var AbstractDatabaseTool
     */
    protected AbstractDatabaseTool $databaseTool;
    private KernelBrowser $client;
    private UserRepository $userRepository;
    private StoreRepository $storeRepository;
    private string $path = '/admin/store/';

    private EntityManagerInterface $entityManager;
    private $faker;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $this->storeRepository = static::getContainer()->get('doctrine')->getRepository(Store::class);
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->faker = Faker\Factory::create();;
    }

    public function test_new_is_redirected_if_user_has_store()
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            StoreFixtures::class
        ]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);
        $store = $user->getStore();

        $this->client->loginUser($user);

        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(302);
        self::assertResponseRedirects(sprintf('%s%s', $this->path, $store->getId()));

    }

    public function test_new_is_accessible_if_user_not_store(): void
    {
        $this->databaseTool->loadFixtures([UserFixtures::class]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);

        $this->client->disableReboot();
        $this->client->loginUser($user);
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'store[name]' => 'Testing',
            'store[vatNumber]' => 'Testing',
            'store[phoneNumber]' => 'Testing',
            'store[description]' => 'Testing',
            'store[streetName]' => 'Testing',
            'store[houseNumber]' => '1',
            'store[postCode]' => '75000',
            'store[city]' => 'Testing',
            'store[email]' => 'Testing@exempl.es',
        ]);

        $fixture = $this->storeRepository->findAll()[0];
        self::assertResponseRedirects(sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertSame(1, $this->storeRepository->count([]));



        self::assertSame('Testing', $fixture->getName());
        self::assertSame('Testing', $fixture->getVatNumber());
        self::assertSame('Testing', $fixture->getPhoneNumber());
        self::assertSame('Testing', $fixture->getDescription());
        self::assertSame($user->getId(), $fixture->getOwner()->getId());
        ;
    }

    public function test_show_store(): void
    {
        ;
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            StoreFixtures::class
        ]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);
        $store = $user->getStore();

        $this->client->loginUser($user);

        $this->client->request('GET', sprintf('%s%s', $this->path, $store->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains($store->getName());

    }

    public function test_edit_store(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            StoreFixtures::class
        ]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);
        $store = $user->getStore();

        $this->client->disableReboot();
        $this->client->loginUser($user);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $store->getId()));

        $this->client->submitForm('Modifier', [
            'store[name]' => 'Something New',
            'store[vatNumber]' => 'Something New',
            'store[phoneNumber]' => 'Something New',
            'store[description]' => 'Something New',
            'store[streetName]' => 'Something New',
            'store[houseNumber]' => '777',
            'store[postCode]' => '77777',
            'store[city]' => 'Something New',
            'store[email]' => 'something@new.test',
        ]);

        self::assertResponseRedirects(sprintf('%s%s', $this->path, $store->getId()));

        $fixture = $this->storeRepository->findAll()[0];

        self::assertSame('Something New', $fixture->getName());
        self::assertSame('Something New', $fixture->getVatNumber());
        self::assertSame('Something New', $fixture->getPhoneNumber());
        self::assertSame('Something New', $fixture->getDescription());
        self::assertSame('Something New', $fixture->getStreetName());
        self::assertSame('777', $fixture->getHouseNumber());
        self::assertSame('77777', $fixture->getPostCode());
        self::assertSame('Something New', $fixture->getCity());
        self::assertSame('something@new.test', $fixture->getEmail());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Store();
        $fixture->setName('Value');
        $fixture->setVatNumber('Value');
        $fixture->setPhoneNumber('Value');
        $fixture->setDescription('Value');
        $fixture->setLogo('Value');
        $fixture->setStreetName('Value');
        $fixture->setHouseNumber('Value');
        $fixture->setPostCode('Value');
        $fixture->setCity('Value');
        $fixture->setEmail('Value');
        $fixture->setSlug('Value');
        $fixture->setOwner('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/admin/store/store/');
        self::assertSame(0, $this->repository->count([]));
    }
}
