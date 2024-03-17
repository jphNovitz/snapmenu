<?php

namespace App\Tests\Admin;

use App\DataFixtures\tests\ProductFixtures;
use App\DataFixtures\tests\UserFixtures;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use JetBrains\PhpStorm\NoReturn;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Faker;

class productControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @var AbstractDatabaseTool
     */
    protected AbstractDatabaseTool $databaseTool;
    private KernelBrowser $client;
    private UserRepository $userRepository;
    private ProductRepository $productRepository;
    private string $path = '/admin/product/';

    private EntityManagerInterface $entityManager;
    private $faker;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $this->productRepository = static::getContainer()->get('doctrine')->getRepository(Product::class);
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->faker = Faker\Factory::create();;
    }

    public function test_admin_product_is_not_accessible_anonymously(): void
    {
        $this->client->request('GET', $this->path);

        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects('/login');
    }

    public function test_admin_product_index_is_accessible_if_logged(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            ProductFixtures::class]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);
        $product = $this->productRepository->findAll()[0];

        $this->client->loginUser($user);
        $crawler = $this->client->request('GET', $this->path);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", 'Liste des produits');
        $this->assertStringContainsString($product->getName(), $crawler->text());
        $this->assertStringContainsString($product->getDescription(), $crawler->text());
        $this->assertStringContainsString($product->getIngredients(), $crawler->text());
        $this->assertStringContainsString($product->getPriceHome(), $crawler->text());
        $this->assertStringContainsString("Modifier", $crawler->text());
        $this->assertStringContainsString("Ajouter", $crawler->text());
    }

    #[NoReturn] public function test_admin_can_add_a_product(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class]);

        $user = $this->userRepository->findOneBy(['email' => 'simple@exempl.es']);
        $this->client->disableReboot();
        $this->client->loginUser($user);

        $crawler = $this->client->request('GET', sprintf('%snew', $this->path));

//        Page new is accessible
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", 'Ajouter un produit');

        $crawler = $this->client->submitForm('Ajouter', [
            'product[name]' => $this->faker->name(),
            'product[description]' => $this->faker->sentence(),
            'product[ingredients]' => $this->faker->words(3, true),
            'product[priceHome]' => '4,00',
            'product[priceAway]' => '3,00',
            'product[veggie]' => 1,
            'product[halal]' => 1,
        ]);

        $this->assertResponseRedirects($this->path, 302);
        $this->assertSame(1, $this->productRepository->count([]));
    }

    public function test_admin_can_update_a_product(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            ProductFixtures::class]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);
        $product = $this->productRepository->findAll()[0];

        $this->client->disableReboot();
        $this->client->loginUser($user);

        $crawler = $this->client->request('GET', sprintf('%s%s/edit', $this->path, $product->getId()));

//        Page new is accessible
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", 'Modifier un produit');

        $name = $this->faker->name();
        $description = $this->faker->sentence();
        $ingredients = $this->faker->words(3, true);
        $price_home = '4,00';
        $price_away = '3,00';
        $veggie = $this->faker->boolean;
        $halal = $this->faker->boolean;

//        Submit the 'new product form'
        $this->client->submitForm('Modifier', [
            'product[name]' => $name,
            'product[description]' => $description,
            'product[ingredients]' => $ingredients,
            'product[priceHome]' => $price_home,
            'product[priceAway]' => $price_away,
            'product[veggie]' => $veggie,
            'product[halal]' => $halal,
        ]);

        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects($this->path);

        $product = $this->productRepository->findOneBy(['name' => $name]);

        $this->assertSame($name, $product->getName());
        $this->assertSame($description, $product->getDescription());
        $this->assertSame($ingredients, $product->getIngredients());
        $this->assertSame($price_home, $product->getPriceHome());
        $this->assertSame($price_away, $product->getPriceAway());
        $this->assertSame($veggie, $product->isVeggie());
        $this->assertSame($halal, $product->isHalal());

    }

    public function test_admin_can_delete_a_product(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            ProductFixtures::class]);

        $user = $this->userRepository->findOneBy(['email' => 'admin@exempl.es']);


        $products = $this->productRepository->findAll();
        $total = count($products);

        $this->client->disableReboot();
        $this->client->loginUser($user);
        $crawler = $this->client->request('GET', sprintf('%s%s/edit', $this->path, $products[0]->getId()));

//        Page new is accessible
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", 'Modifier un produit');

        $this->client->submitForm('Supprimer');
        $this->assertResponseRedirects($this->path, 302);

    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
