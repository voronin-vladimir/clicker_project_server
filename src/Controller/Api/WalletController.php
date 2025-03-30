<?php

namespace App\Controller\Api;

use App\Services\Player\PlayerException;
use App\Services\Wallet\WalletService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class WalletController extends AbstractController
{
    private EntityManagerInterface $em;

    private WalletService $walletService;

    public function __construct(EntityManagerInterface $em, WalletService $walletService)
    {
        $this->em = $em;
        $this->walletService = $walletService;
    }

    #[Route('api/wallet/guid/{guid}', name: 'get_wallet_by_guid', methods: ['GET'])]
    public function getWalletByGuid(string $guid): JsonResponse
    {
        try
        {
            $wallet = $this->walletService->getWallet($guid);
            $response = $this->json(['coins' => $wallet->getCoins(),]);
        }
        catch (PlayerException $e)
        {
            $response = $this->json(['error' => $e->getMessage()], $e->getCode());
        }

        return $response;
    }

    #[Route('api/wallet/guid/{guid}', name: 'update_wallet_by_guid', methods: ['PUT'])]
    public function updateWalletByGuid(string $guid, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['coins']) || !is_numeric($data['coins']))
        {
            return $this->json(['error' => 'Invalid coins value'], 400);
        }

        $coins = (int)$data['coins'];

        $totalCoins = $this->walletService->addCoins($guid, $coins);

        return $this->json([
            'coins' => $totalCoins,
        ]);
    }
}