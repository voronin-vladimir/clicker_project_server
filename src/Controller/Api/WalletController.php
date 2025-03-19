<?php

namespace App\Controller\Api;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class WalletController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('api/wallet/guid/{guid}', name: 'get_wallet_by_guid', methods: ['GET'])]
    public function getWalletByGuid(string $guid, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $entityManager->getRepository(Users::class)->findOneBy(['guid' => $guid]);

        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        $wallet = $user->getWallet();

        if (!$wallet) {
            return $this->json(['error' => 'Wallet not found'], 404);
        }

        return $this->json([
            'userId' => $user->getId(),
            'coins' => $wallet->getCoins(),
        ]);
    }

    #[Route('api/wallet/guid/{guid}', name: 'update_wallet_by_guid', methods: ['PUT'])]
    public function updateWalletByGuid(string $guid, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $entityManager->getRepository(Users::class)->findOneBy(['guid' => $guid]);

        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        $wallet = $user->getWallet();

        if (!$wallet) {
            return $this->json(['error' => 'Wallet not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['coins']) || !is_numeric($data['coins'])) {
            return $this->json(['error' => 'Invalid coins value'], 400);
        }

        $wallet->setCoins($wallet->getCoins() + (int)$data['coins']);

        $entityManager->persist($wallet);
        $entityManager->flush();

        return $this->json([
            'userId' => $user->getId(),
            'coins' => $wallet->getCoins(),
        ]);
    }
}