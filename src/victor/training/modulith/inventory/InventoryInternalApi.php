<?php

namespace victor\training\modulith\inventory;

use Doctrine\ORM\EntityManager;
use victor\training\modulith\inventory\app\StockService;

class InventoryInternalApi
{

    public function __construct(private StockService $stockService,
                                private EntityManager        $entityManager)
    {
    }

    public function reserveStock(int $orderId, array $items): void
    {
        $this->stockService->reserveStock($orderId, $items);
    }

    public function confirmReservation(int $orderId): void
    {
        $this->stockService->confirmReservation($orderId);
    }
}