<?php

namespace App\Entity;

use App\Repository\UserWalletRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserWalletRepository::class)]
class UserWallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: "user_wallet")]
    #[ORM\JoinColumn(nullable: false)]
    private Users $user;

    #[ORM\Column]
    private ?int $coinsAmount = 100;

    public function __construct(Users $user)
    {
        $this->user = $user;
        $this->coinsAmount = 100;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
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
}
