<?php

namespace App\Services\Player;

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;

class PlayerService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @throws PlayerException
     */
    public function getPlayer(string $guid): ?Player
    {
        $player = $this->em->getRepository(Player::class)->findOneBy(['guid' => $guid]);

        if ($player == null) {
            throw new PlayerException(PlayerExceptionCase::InvalidPlayer);
        }

        return $player;
    }

    /**
     * @throws PlayerException
     */
    public function registerPlayer(string $guid): void
    {
        $existingUser = $this->em->getRepository(Player::class)->findOneBy(['guid' => $guid]);
        if ($existingUser)
        {
            throw new PlayerException(PlayerExceptionCase::PlayerAlreadyExists);
        }

        $newPlayer = new Player();
        $newPlayer->setGuid($guid);

        $this->em->persist($newPlayer);
        $this->em->flush();
    }
}