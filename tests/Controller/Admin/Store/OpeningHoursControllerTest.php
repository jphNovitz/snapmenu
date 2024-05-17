<?php

namespace App\Tests\Controller\Admin\Store;

use App\DataFixtures\tests\StoreFixtures;
use App\DataFixtures\tests\UserFixtures;
use App\Entity\OpeningHours;
use App\Entity\Store;
use App\Entity\User;
use App\Repository\OpeningHoursRepository;
use App\Repository\StoreRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Faker;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OpeningHoursControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @var AbstractDatabaseTool
     */
    protected AbstractDatabaseTool $databaseTool;
    private KernelBrowser $client;
    private UserRepository $userRepository;
    private StoreRepository $storeRepository;
    private OpeningHoursRepository $openingHoursRepository;
    private string $path = '/admin/store/opening/';

    private EntityManagerInterface $entityManager;
    private $faker;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $this->openingHoursRepository = static::getContainer()->get('doctrine')->getRepository(OpeningHours::class);
        $this->storeRepository = static::getContainer()->get('doctrine')->getRepository(Store::class);
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->faker = Faker\Factory::create();;
    }

    public function test_opening_index(): void
    {
        $this->databaseTool->loadFixtures([UserFixtures::class]);
        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);

        $this->client->loginUser($user);
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Horaire');
        self::assertStringContainsString('Ajouter', $crawler->text());
    }

    public function test_opnening_new(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            StoreFixtures::class]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);
        $store = $this->storeRepository->findAll()[0];

        $this->client->disableReboot();
        $this->client->loginUser($user);
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $date = new DateTimeImmutable();
        $formattedDate = $date->format('H:i');

        $this->client->submitForm('Ajouter', [
            'opening_hours[dayOfWeek]' => '1',
            'opening_hours[openTime]' => $formattedDate,
            'opening_hours[closeTime]' => $formattedDate,
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->openingHoursRepository->count([]));
    }

    public function test_opening_edit(): void
    {
        $this->databaseTool->loadFixtures([
        UserFixtures::class,
        StoreFixtures::class]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);
        $store = $this->storeRepository->findAll()[0];

        $this->client->disableReboot();
        $this->client->loginUser($user);

        $fixture = new OpeningHours();
        $fixture->setDayOfWeek('1');
        $fixture->setOpenTime(new DateTimeImmutable());
        $fixture->setCloseTime(new DateTimeImmutable());
        $fixture->setStore($store);

        $this->entityManager->persist($fixture);
        $this->entityManager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $date = new DateTimeImmutable('now');
        $formattedDate = $date->format('H:i');
        $this->client->submitForm('Modifier', [
            'opening_hours[dayOfWeek]' => '2',
            'opening_hours[openTime]' => $formattedDate,
            'opening_hours[closeTime]' => $formattedDate,
        ]);

        self::assertResponseRedirects('/admin/store/opening/');

        $fixture = $this->openingHoursRepository->findAll();

        self::assertSame('2', $fixture[0]->getDayOfWeek());
        self::assertSame($formattedDate, $fixture[0]->getOpenTime()->format('H:i'));
        self::assertSame($formattedDate, $fixture[0]->getCloseTime()->format('H:i'));
    }

    public function test_opening_remove(): void
    {

        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            StoreFixtures::class]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);
        $store = $this->storeRepository->findAll()[0];

        $this->client->disableReboot();
        $this->client->loginUser($user);

        $fixture = new OpeningHours();
        $fixture->setDayOfWeek('1');
        $fixture->setOpenTime(new DateTimeImmutable());
        $fixture->setCloseTime(new DateTimeImmutable());
        $fixture->setStore($store);

        $this->entityManager->persist($fixture);
        $this->entityManager->flush();

        self::assertSame(1, $this->openingHoursRepository->count([]));

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));
        $this->client->submitForm('Supprimer');

        self::assertResponseRedirects('/admin/store/opening/');
        self::assertSame(0, $this->openingHoursRepository->count([]));

    }
}
