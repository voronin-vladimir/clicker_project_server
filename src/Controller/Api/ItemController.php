<?php

namespace App\Controller\Api;

use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    #[Route('api/list/items', name: 'get_items', methods: ['GET'])]
    public function getAllItems(ItemRepository $itemRepository): JsonResponse
    {
        $items = $itemRepository->findAll();
        return $this->json($items);
    }
}