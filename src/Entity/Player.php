<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
#[ORM\Table(uniqueConstraints: [
    new ORM\UniqueConstraint(name: "unique_guid", columns: ["guid"])
])]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $guid = null;

    #[ORM\ManyToMany(targetEntity: Item::class)]
    #[ORM\JoinTable(name: "player_items")]
    private Collection $items;

    #[ORM\OneToOne(mappedBy: "player", cascade: ["persist", "remove"])]
    private ?Wallet $wallet = null;

    public function __construct()
    {
        $this->wallet = new Wallet($this);
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setGuid(string $guid): static
    {
        $this->guid = $guid;

        return $this;
    }

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        $this->items->add($item);
        return $this;
    }
}
