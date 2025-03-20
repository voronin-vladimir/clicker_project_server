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
            ['Iron Ring', 1],
            ['Silver Ring', 3],
            ['Gold Ring', 5],
            ['Emerald Ring', 7],
            ['Ruby Ring', 10],
            ['Sapphire Ring', 15],
            ['Amethyst Ring', 20],
            ['Diamond Ring', 30],
            ['Celestial Ring', 50],
            ['Titanium Ring', 100],
        ];

        foreach ($items as [$name, $modifier]) {
            $item = new Item($name, $modifier);
            $manager->persist($item);
        }

        $manager->flush();
    }
}