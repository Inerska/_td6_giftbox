<?php
declare(strict_types=1);

namespace gift\test\services\prestations;

use Faker\Factory;
use gift\app\models\Categorie;
use gift\app\models\Prestation;
use gift\app\services\PrestationNotFoundException;
use gift\app\services\PrestationsService;
use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase;
use Twig\Extension\EscaperExtension;

final class PrestationServiceTest extends TestCase
{
    private static array $prestations = [];
    private static array $categories = [];

    public function setUp(): void
    {
        parent::setUp();

        $config = new DB();
        $config->addConnection(parse_ini_file(__DIR__ . '../../src/conf/gift.db.conf.ini.test'));
        $config->setAsGlobal();
        $config->bootEloquent();
        $faker = Factory::create('fr_FR');

        $c1 = Categorie::create(['libelle' => $faker->word(), 'description' => $faker->paragraph(3)]);
        $c2 = Categorie::create(['libelle' => $faker->word(), 'description' => $faker->paragraph(4)]);
        self::$categories = [$c1, $c2];

        for ($i = 1; $i <= 4; $i++) {
            $prestation = Prestation::create(['id' => $faker->uuid(), 'libelle' => $faker->word(), 'description' => $faker->paragraph(3), 'tarif' => $faker->randomFloat(2, 20, 200), 'img' => $faker->imageUrl(), 'unite' => $faker->numberBetween(1, 3), 'cat_id' => $faker->numberBetween(1, 4)]);
            array_push(self::$prestations, $prestation);
        }

        self::$prestations[0]->categorie()->associate($c1);
        self::$prestations[0]->save();
        self::$prestations[1]->categorie()->associate($c1);
        self::$prestations[1]->save();
        self::$prestations[2]->categorie()->associate($c2);
        self::$prestations[2]->save();
        self::$prestations[3]->categorie()->associate($c2);
        self::$prestations[3]->save();
    }

    public function tearDown(): void
    {
        foreach (self::$categories as $category) {
            $category->delete();
        }

        foreach (self::$prestations as $prestation) {
            $prestation->delete();
        }

        parent::tearDown();
    }

    /**
     * @test
     */
    public function should_get_all_prestations(): void
    {
        $service = new PrestationsService();
        $prestations = $service->getPrestations();

        $this->assertIsArray($prestations);
        $this->assertCount(4, $prestations);
    }

    /**
     * @test
     */
    public function should_get_all_categories(): void
    {
        $service = new PrestationsService();
        $categories = $service->getCategories();

        $this->assertIsArray($categories);
        $this->assertCount(2, $categories);
    }

    /**
     * @test
     */
    public function should_get_prestation_by_id(): void
    {
        $service = new PrestationsService();
        $prestation = $service->getPrestationById(self::$prestations[0]->id);

        $this->assertIsArray($prestation);
        $this->assertCount(8, $prestation);
        $this->assertEquals(self::$prestations[0]->id, $prestation['id']);
    }

    /**
     * @test
     */
    public function should_get_prestations_by_category_id(): void
    {
        $service = new PrestationsService();
        $prestations = $service->getPrestationsByCategorieId(self::$categories[0]->id);

        $this->assertIsArray($prestations);
        $this->assertCount(2, $prestations);
    }

    /**
     * @test
     */
    public function should_throw_exception_when_prestation_not_found(): void
    {
        $service = new PrestationsService();

        $this->expectException(PrestationNotFoundException::class);
        $service->getPrestationById('unknown');
    }

    /**
     * @test
     */
    public function should_throw_exception_when_category_not_found(): void
    {
        $service = new PrestationsService();

        $this->expectException(PrestationNotFoundException::class);
        $service->getPrestationsByCategorieId(-1);
    }
}