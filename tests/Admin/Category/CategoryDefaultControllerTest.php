<?php

namespace Admin\Category;

use App\DataFixtures\tests\CategoryFixtures;
use App\DataFixtures\tests\UserFixtures;
use App\Entity\Category;
use App\Entity\CategoryDefault;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use JetBrains\PhpStorm\NoReturn;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryDefaultControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @var AbstractDatabaseTool
     */
    protected AbstractDatabaseTool $databaseTool;
    private KernelBrowser $client;
    private UserRepository $userRepository;
    private string $path = '/admin/category/';

    private EntityManagerInterface $entityManager;
    private $faker;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->faker = Faker\Factory::create();;
    }

    #[NoReturn] public function test_admin_can_add_a_default_category(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);
        $this->client->disableReboot();
        $this->client->loginUser($user);

        $this->client->request('GET', sprintf('%sdefault/new', $this->path));

//        Page new is accessible
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", 'Ajouter une categorie');

        $crawler = $this->client->submitForm('Ajouter', [
            'category[name]' => $this->faker->name(),
        ]);

        $this->assertResponseRedirects($this->path, 302);
        $this->assertSame(1, $this->entityManager->getRepository(Category::class)->count([]));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
