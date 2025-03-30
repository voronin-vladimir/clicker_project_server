<?php

namespace App\Services\Items;

use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;

class ItemsService
{

    private EntityManagerInterface $em;
    private ItemRepository $itemRepository;

    public function __construct(EntityManagerInterface $em, ItemRepository $itemRepository)
    {
        $this->em = $em;
        $this->itemRepository = $itemRepository;
    }

    public function getAllItems()
    {
        $items = $this->itemRepository->findAll();
        return $this->json($items);
    }

}