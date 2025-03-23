<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "player_items")]
class PlayerItem
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: "items")]
    #[ORM\JoinColumn(nullable: false)]
    private Player $player;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Item::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Item $item;

    #[ORM\Column(type: "integer")]
    private int $quantity = 1;

    public function __construct(Player $player, Item $item, int $quantity = 1)
    {
        $this->player = $player;
        $this->item = $item;
        $this->quantity = $quantity;
    }

    public function addQuantity(int $amount): void
    {
        $this->quantity += $amount;
    }

    public function getItem(): Item
    {
        return $this->item;
    }
}