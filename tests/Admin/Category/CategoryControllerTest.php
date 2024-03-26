<?php

namespace Admin\Category;

use App\DataFixtures\tests\CategoryFixtures;
use App\DataFixtures\tests\UserFixtures;
use App\Entity\Category;
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

class CategoryControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @var AbstractDatabaseTool
     */
    protected AbstractDatabaseTool $databaseTool;
    private KernelBrowser $client;
    private UserRepository $userRepository;
    private CategoryRepository $categoryRepository;
    private string $path = '/admin/category/';

    private EntityManagerInterface $entityManager;
    private $faker;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $this->categoryRepository = static::getContainer()->get('doctrine')->getRepository(Category::class);
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->faker = Faker\Factory::create();;
    }

    public function test_admin_category_is_not_accessible_anonymously(): void
    {
        $this->client->request('GET', $this->path);

        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects('/login');
    }

    public function test_admin_category_index_is_accessible_if_logged(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            CategoryFixtures::class]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);
        $category = $this->categoryRepository->findOneBy(['name' => 'Lorem Custom']);

        $this->client->loginUser($user);
        $crawler = $this->client->request('GET', $this->path);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", 'Liste des categories');
        $this->assertStringContainsString($category->getName(), $crawler->text());
        $this->assertStringContainsString("Modifier", $crawler->text());
        $this->assertStringContainsString("Ajouter", $crawler->text());
    }

    public function test_admin_can_update_a_category(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            categoryFixtures::class]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);
        $product = $this->categoryRepository->findOneBy(['name' => 'Lorem Custom']);

        $this->client->disableReboot();
        $this->client->loginUser($user);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $product->getId()));

//        Page new is accessible
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", 'Modifier une categorie');

        $name = $this->faker->name();

//        Submit the 'new product form'
        $this->client->submitForm('Modifier', [
            'category[name]' => $name
        ]);

        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects($this->path);

        $category = $this->categoryRepository->findOneBy(['name' => $name]);

        $this->assertSame($name, $category->getName());
    }

    public function test_admin_can_delete_a_category(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            CategoryFixtures::class]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);


        $categories = $this->categoryRepository->findBy(['name' => 'Lorem Custom']);
        $total = count($categories);

        $this->client->disableReboot();
        $this->client->loginUser($user);
        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $categories[0]->getId()));

//        Page new is accessible
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", 'Modifier une categorie');

        $this->client->submitForm('Supprimer');
        $this->assertResponseRedirects($this->path, 302);
        $this->assertCount($total - 1, $this->categoryRepository->findBy(['name' => 'Lorem Custom']));

    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
