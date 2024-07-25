<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugging;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugging=$slugger;
    }
    public function load(ObjectManager $manager): void
    {

        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));
        for ($i = 0; $i < 9; $i++) {

            $recipe = new Recipe();
            $recipe->SetName($faker->unique->foodName);
            $slug = $this->slugging->slug($recipe->getName());
            $recipe->setSlug(strtolower($slug));
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
