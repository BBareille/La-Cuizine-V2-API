<?php

namespace App\DataFixtures;

use App\Entity\Ingredients;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tomates = new Ingredients();
        $tomates ->setName('tomates');
        $manager->persist($tomates);

        $manager->flush();
    }
}
