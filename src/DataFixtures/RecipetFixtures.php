<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipetFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));

        for ($i = 0; $i < 12; $i++) {

            $recipe = new Recipe();
            $recipe->SetName($faker->MeatName);
            $recipe->SetSlug($faker->MeatName);
            $recipe->SetTime($faker->randomDigitNotNull());
            $recipe->SetPeople($faker->randomDigitNotNull());
            $recipe->SetDifficulty('20');
            $recipe->SetStep('');
            $recipe->SetPrice($faker->randomDigitNotNull());
            $recipe->setFavorite('');
            $recipe->setDateOfCreation(new DateTimeImmutable());
            $recipe->setUpdateDate(new DateTimeImmutable());
            $manager->persist($recipe);
        }

        $manager->flush();

        $manager->flush();
    }
}
