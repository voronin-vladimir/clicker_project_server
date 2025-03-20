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

    public function __construct(string $name, int $modifier)
    {
        $this->name = $name;
        $this->modifier = $modifier;
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
}