<?php

namespace App\Controller\Api;

use App\Entity\Player;
use App\Repository\ItemRepository;
use App\Repository\PlayerRepository;
use App\Repository\WalletRepository;
use App\Services\Items\ItemsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    private ItemsService $itemsService;

    public function __construct(ItemsService $itemsService)
    {
        $this->$itemsService = $itemsService;
    }

    #[Route('api/list/items', name: 'get_items', methods: ['GET'])]
    public function getAllItems(ItemRepository $itemRepository): JsonResponse
    {
        return $this->itemsService->getAllItems();
//        $items = $itemRepository->findAll();
//        return $this->json($items);
    }

    #[Route('api/player/items/{guid}', name: 'get_player_items', methods: ['GET'])]
    public function getPlayerItems(string $guid, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $entityManager->getRepository(Player::class)->findOneBy(['guid' => $guid]);

        if (!$user)
        {
            return $this->json(['error' => 'User not found'], 404);
        }

        $items = $user->getItems();

        if (!$items)
        {
            return $this->json(['error' => 'Items not found'], 404);
        }

        return $this->json([
            'userId' => $user->getId(),
            'items' => $this->json($items),
        ]);
    }


    #[Route('api/player/items/buy', name: 'update_player_items', methods: ['PUT'])]
    public function buyItems(Request $request, EntityManagerInterface $em, PlayerRepository $playerRepository, ItemRepository $itemRepository, WalletRepository $walletRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $player = $playerRepository->findOneBy(['guid' => $data['player_id']]);

        if (!$player)
        {
            return new JsonResponse(['error' => 'Player not found'], 404);
        }

        $item = $itemRepository->find($data['item_id']);

        if (!$item)
        {
            return new JsonResponse(['error' => 'Item not found'], 404);
        }

        $quantity = $data['item_quantity'] ?? 1;

        $player->addItem($item, $quantity);
        $player->getWallet()->spendCoins($item->getCost());
        $em->persist($player);
        $em->flush();

        return new JsonResponse(['success' => true, 'message' => "Items purchased"]);
    }
}