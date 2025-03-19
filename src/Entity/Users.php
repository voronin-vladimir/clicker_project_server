<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\Table(uniqueConstraints: [
    new ORM\UniqueConstraint(name: "unique_guid", columns: ["guid"])
])]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $guid = null;


    #[ORM\OneToOne(mappedBy: "user", cascade: ["persist", "remove"])]
    private ?UserWallet $wallet = null;

    public function __construct()
    {
        $this->wallet = new UserWallet($this);
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

    public function getWallet(): ?UserWallet
    {
        return $this->wallet;
    }
}
