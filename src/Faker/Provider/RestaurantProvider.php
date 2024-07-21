<?php

namespace App\Faker\Provider;

use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Base as BaseProvider;

use FakerRestaurant\Provider\fr_FR\Restaurant;


final class RestaurantProvider extends BaseProvider
{
//    public static function create(): Generator
//    {
//        $faker = Factory::create();
//        $faker->addProvider(new Restaurant($faker));
//
//        return $faker;
//    }

    private $restaurant;

    public function __construct()
    {
        $this->restaurant = new Restaurant(new \Faker\Generator());
    }

    public function foodName()
    {
        return $this->restaurant->foodName();
    }

    public function dairyName()
    {
        return $this->restaurant->dairyName();
    }

    public function beverageName()
    {
        return $this->restaurant->beverageName();
    }

    public function vegetableName()
    {
        return $this->restaurant->vegetableName();
    }

    public function fruitName()
    {
        return $this->restaurant->fruitName();
    }

    public function meatName()
    {
        return $this->restaurant->meatName();
    }

    public function sauceName()
    {
        return $this->restaurant->sauceName();
    }

    public function ingredients($n)
    {
        $ingredients = '';
        for ($i = 0; $i < $n; $i++) {
            $ingredients .= ', ' . $this->restaurant->vegetableName();
        }

        return $this->meatName() . ', ' . $this->sauceName() . ' ' . $ingredients;
    }
}