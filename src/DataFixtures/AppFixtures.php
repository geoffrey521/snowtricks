<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Factory\CategoryFactory;
use App\Factory\CommentFactory;
use App\Factory\ImageFactory;
use App\Factory\TrickFactory;
use App\Factory\UserFactory;
use App\Factory\VideoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoryNames = ['Grabs', 'Rail tricks', 'One foot tricks', 'Rotations'];

        foreach ($categoryNames as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
        }

        // create 5 categories
        //     CategoryFactory::createMany(5);

        // create 10 basic users
        UserFactory::createMany(10);

        //create 1 user admin
        UserFactory::createOne([
            'roles' => ['ROLE_ADMIN'],
            'username' => 'admin',
            'email' => 'admin@snowtricks.fr',
            'isActive' => true,
        ]);

        ImageFactory::createMany(30);

        TrickFactory::createMany(
            20,
            [
                'images' => ImageFactory::new()->many(2, 5),
                'videos' => VideoFactory::new()->many(2, 5),
                'author' => UserFactory::randomOrCreate(),
                'category' => CategoryFactory::randomOrCreate(),
                'comments' => CommentFactory::new()->many(2, 10),
            ]
        );

        $manager->flush();
    }
}
