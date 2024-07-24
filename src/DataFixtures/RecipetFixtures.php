<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RecipetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $slugger=\Faker\Factory::create();

        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));
        for ($i = 0; $i < 20; $i++) {

            $recipe = new Recipe();
            $recipe->SetName($faker->foodName);
            $recipe->SetSlug('');
            $recipe->SetTime($faker->randomDigitNotNull());
            $recipe->SetPeople($faker->randomDigitNotNull());
            $recipe->SetDifficulty('20');
            $recipe->SetStep('');
            $recipe->SetPrice($faker->randomDigitNotNull());
            $recipe->setFavorite('');
            $recipe->setDateOfCreation(new DateTimeImmutable());
            $recipe->setUpdateDate(new DateTimeImmutable());
            $recipe->addIngredient($this->getReference('INGREDIENT'.mt_rand(0,19)));
            $manager->persist($recipe);

            $recipe= new Recipe();
    
            $manager->flush();
        }


    }
    public function getDependencies()
    {
        return[IngredientFixtures::class];
    }
}
