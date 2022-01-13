<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\ImageFactory;
use App\Factory\TrickFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        // create 5 categories
        CategoryFactory::createMany(5);

        // create 10 basic users
        UserFactory::createMany(10);

        //create 1 user admin
        UserFactory::createOne([
            'roles' => ['ROLE_ADMIN'],
        ]);

        ImageFactory::createMany(30);

        TrickFactory::createMany(300,
            [
                'images' => ImageFactory::new()->many(2, 5),
                'author' => UserFactory::randomOrCreate(),
                'category' => CategoryFactory::randomOrCreate()
            ]
        );

        $manager->flush();
    }
}
