<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Season;
use DateTimeImmutable;
use App\Entity\Comment;
use App\Entity\Ingredient;
use App\Entity\Newsletter;
use App\Entity\RecipeIngredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    // $product = new Product();
    // $manager->persist($product);
    $faker = Factory::create('fr_FR');

    $users=[];
    for ($i = 0; $i <10; $i++) {
        $user = new User();

        $user
            ->setUsername($faker->firstName() . ' ' . $faker->lastName())
            ->setAvatar($faker->imageUrl(640, 480, 'person', true))
            ->setEmail($faker->safeEmail())
            ->setPassword("test".$i)
            ->setIsSubscribed($faker->boolean())
            ->setRoles(['ROLE_USER'])

        ;
        $users[]= $user;
        $manager->persist($user);
    }

        $summerStart = new \DateTimeImmutable('2023-06-21');
        $fallStart = new \DateTimeImmutable('2023-09-23');
        $springStart = new \DateTimeImmutable('2023-03-20');
        $winterStart = new \DateTimeImmutable('2023-12-21');

        $summer = new Season();
        $summer
            ->setName('Summer')
            ->setStartAt($summerStart)
            ->setEndAt($fallStart)
        ;   
        $manager->persist($summer);
        
        $spring = new Season();
        $spring
            ->setName('Spring')
            ->setStartAt($springStart)
            ->setEndAt($summerStart)
        ;
        $manager->persist($spring);
        
        $winter = new Season();
        $winter
            ->setName('Winter')
            ->setStartAt($winterStart)
            ->setEndAt($springStart)
        ;
        $manager->persist($winter);
        
        $fall = new Season();
        $fall
            ->setName('Fall')
            ->setStartAt($fallStart)
            ->setEndAt($winterStart)
        ;
        $manager->persist($fall);

        $seasons = [$summer,$spring,$winter,$fall];

        $ingredients=[];
        for ($i = 0; $i<10; $i++) {
            $ingredient = new Ingredient();
    
            $ingredient
                ->setName($faker->word())
                ->setType($faker->randomElement(['fruit', 'legume']))
                ->setDescription($faker->text())
                ->setImage($faker->imageUrl(640, 480, 'food', true))
                ->addSeason($faker->randomElement($seasons))
            ;
    
            $manager->persist($ingredient);
            $ingredients[]=$ingredient;
    }

        $recipes=[];
        for ($i = 0; $i<10; $i++) {
            $recipe = new Recipe();

            $recipe
                ->setName($faker->words(10, true))
                ->setDescription($faker->text())
                ->setLevel($faker->numberBetween(1, 3))
                ->setImage($faker->imageUrl(640, 480, 'recipe', true))
                ->addSeason($faker->randomElement($seasons))
                ->addUser($faker->randomElement($users))
            ;
            $recipes[]= $recipe;
            $manager->persist($recipe);
        }

        $comments=[];
        for ($i = 0; $i<10; $i++) {
            $comment = new Comment();

            $comment
                ->setContent($faker->sentence(12))
                ->setUser($faker->randomElement($users))
                ->setRecipe($faker->randomElement($recipes))
            ;
            $manager->persist($comment);
            $comments[] = $comment;
        }

        $newsletter = [];
        for ($i  = 0; $i<10; $i++) {
            $newsletter = new Newsletter();

            $newsletter
                ->setContent($faker->sentence(30))
                ->setSendAt(DateTimeImmutable::createFromMutable($faker->dateTime()))
                ->addRecipe($faker->randomElement($recipes))
                ->addRecipe($faker->randomElement($recipes))
                ->addRecipe($faker->randomElement($recipes))
                ->addRecipe($faker->randomElement($recipes))
            ;
            $manager->persist($newsletter);
            $newsletters[] = $newsletter;
        }

        $recipeIngredients = [];
        for($si =0; $i<10; $i++){

        $recipeIngredient = new RecipeIngredient();
        $recipeIngredient
            ->setRecipe($faker->randomElement($recipes))
            ->setingredient($faker->randomElement($ingredients))
            ->setQuantity($faker->randomDigitNotNull() . ' ' . $faker->randomElement((['kg', 'g', 'l', 'ml'])))
        ;
        $manager->persist($recipeIngredient);
        $recipeIngredients[] = $recipeIngredient;

        }



        $manager->flush();
    }
}
