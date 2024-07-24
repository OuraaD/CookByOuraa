<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));

        for ($i = 0; $i < 20; $i++) {

            $ingredient = new Ingredient();
            $ingredient->SetName($faker->vegetableName);
            $ingredient->SetPrice($faker->randomDigitNotNull());
            $ingredient->setDateOfCreation(new DateTimeImmutable());
            $manager->persist($ingredient);
            $this->addReference('INGREDIENT'.$i, $ingredient);
        }

        $manager->flush();
    }
}
