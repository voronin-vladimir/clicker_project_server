<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: "wallet")]
    #[ORM\JoinColumn(nullable: false)]
    private Player $player;

    #[ORM\Column]
    private ?int $coinsAmount;

    public function __construct(Player $player)
    {
        $this->player = $player;
        $this->coinsAmount = 100;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoins(): ?int
    {
        return $this->coinsAmount;
    }

    public function setCoins(int $coinsAmount): static
    {
        $this->coinsAmount = $coinsAmount;
        return $this;
    }

    public function spendCoins(int $amount): static
    {
        $this->coinsAmount -= $amount;
        return $this;
    }

    public function addCoins(int $amount): static
    {
        $this->coinsAmount += $amount;
        return $this;
    }
}
