<?php

declare(strict_types=1);

namespace gift\test\services\box;

use Faker\Factory;
use gift\app\models\Box;
use gift\app\models\Prestation;
use gift\app\services\box\BoxService;
use gift\app\services\PrestationNotFoundException;
use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase;

final class BoxServiceTest extends TestCase
{
    private static array $boxes = [];
    private static array $prestations = [];

    public function setUp(): void
    {
        parent::setUp();

        $config = new DB();
        $config->addConnection(parse_ini_file(__DIR__ . '../../src/conf/gift.db.conf.ini.test'));
        $config->setAsGlobal();
        $config->bootEloquent();
        $faker = Factory::create('fr_FR');

        $box1 = BoxService::create([
            'name' => $faker->word(),
            'description' => $faker->paragraph(1),
        ]);
        $box2 = BoxService::create([
            'name' => $faker->word(),
            'description' => $faker->paragraph(1),
        ]);
        self::$boxes = [$box1, $box2];

        for ($i = 1; $i <= 4; $i++) {
            $prestation = Prestation::create([
                'id' => $faker->uuid(),
                'libelle' => $faker->word(),
                'description' => $faker->paragraph(3),
                'tarif' => $faker->randomFloat(2, 20, 200),
                'img' => $faker->imageUrl(),
                'unite' => $faker->numberBetween(1, 3),
                'cat_id' => $faker->numberBetween(1, 4)]);
            array_push(self::$prestations, $prestation);
        }

        foreach (self::$prestations as $prestation) {
            $prestation->save();
        }

    }

    public function tearDown(): void
    {
        foreach (self::$boxes as $box) {
            $box->delete();
        }

        foreach (self::$prestations as $prestation) {
            $prestation->delete();
        }

        parent::tearDown();
    }

    /**
     * @test
     */
    public function should_get_all_boxes(): void
    {
        $boxes = Box::all();
        $this->assertCount(2, $boxes);
    }

    /**
     * @test
     * @throws PrestationNotFoundException
     */
    public function should_get_box_by_id(): void
    {
        $box = BoxService::getById(self::$boxes[0]->id);
        $this->assertEquals(self::$boxes[0]->id, $box->id);
    }

    /**
     * @test
     * @throws PrestationNotFoundException
     */
    public function should_throw_exception_when_box_not_found(): void
    {
        $this->expectException(PrestationNotFoundException::class);
        BoxService::getById('not_found');
    }
}