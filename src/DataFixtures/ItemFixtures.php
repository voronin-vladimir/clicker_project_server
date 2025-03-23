<?php

namespace App\DataFixtures;

use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ItemFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $items = [
            ['Iron Ring', 1, 10],
            ['Silver Ring', 3, 30],
            ['Gold Ring', 5, 75],
            ['Emerald Ring', 7, 150],
            ['Ruby Ring', 10, 300],
            ['Sapphire Ring', 15, 600],
            ['Amethyst Ring', 20, 1200],
            ['Diamond Ring', 30, 2500],
            ['Celestial Ring', 50, 5000],
            ['Titanium Ring', 100, 10000],
        ];

        foreach ($items as [$name, $modifier, $cost]) {
            $item = new Item($name, $modifier, $cost);
            $manager->persist($item);
        }

        $manager->flush();
    }
}
