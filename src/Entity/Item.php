<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 100)]
    private string $name;

    #[ORM\Column(type: "integer")]
    private int $modifier;

    #[ORM\Column(type: "integer")]
    private int $cost;

    public function __construct(string $name, int $modifier, int $cost)
    {
        $this->name = $name;
        $this->modifier = $modifier;
        $this->cost = $cost;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getModifier(): int
    {
        return $this->modifier;
    }

    public function getCost(): int
    {
        return $this->cost;
    }
}