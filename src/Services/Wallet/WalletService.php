<?php

namespace App\Services\Wallet;

use App\Entity\Wallet;
use App\Services\Player\PlayerException;
use App\Services\Player\PlayerExceptionCase;
use App\Services\Player\PlayerService;
use Doctrine\ORM\EntityManagerInterface;

class WalletService
{
    private PlayerService $playerService;
    private EntityManagerInterface $em;

    public function __construct(PlayerService $playerService, EntityManagerInterface $em)
    {
        $this->playerService = $playerService;
        $this->em = $em;
    }

    /**
     * @throws PlayerException
     */
    public function getWallet(string $guid): ?Wallet
    {
        $player = $this->playerService->getPlayer($guid);

        if ($player == null)
        {
            throw new PlayerException(PlayerExceptionCase::InvalidPlayer);
        }

        return $player->getWallet();
    }

    /**
     * @throws PlayerException
     */
    public function addCoins(string $guid, int $coins): int
    {
        try
        {
            $wallet = $this->getWallet($guid)->addCoins($coins);

            $this->em->persist($wallet);
            $this->em->flush();

            return $wallet->getCoins();
        }
        catch (PlayerException $e)
        {
            throw new PlayerException(PlayerExceptionCase::InvalidPlayer);
        }
    }
}