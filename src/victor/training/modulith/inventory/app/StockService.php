<?php

namespace victor\training\modulith\inventory\app;

use Doctrine\ORM\EntityManager;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use victor\training\modulith\common\LineItem;
use victor\training\modulith\inventory\interapi\StockUpdatedEvent;

class StockService
{
    public function __construct(
        private EntityManager $entityManager,
        private EventDispatcherInterface $eventDispatcher
    )
    {
    }

    /**
     * @param LineItem[] $items
     */
    public function reserveStock(int $orderId, LineItem $items): void
    {
        $this->entityManager->beginTransaction();
        foreach ($items as $item) {
            $this->subtractStock($item->getProductId(), $item->getCount());
            $this->createReservation($orderId, $item->getProductId(), $item->getCount());
        }
        $this->entityManager->commit();
    }

    private function createReservation(int $orderId, int $productId, int $count): void
    {
        $reservation = (new StockReservation())
            ->setOrderId($orderId)
            ->setProductId($productId)
            ->setItems($count);
        $this->entityManager->persist($reservation);
    }

    private function subtractStock(int $productId, int $count): void
    {
        $stock = $this->entityManager->getRepository(Stock::class)->findOneBy(['productId' => $productId]);
        $stock->remove($count);
        // WARNING: NU PUNE EVENTURI DECAT PESTE MARGINI PE CARE PLANUESTI (ai deja buget)
        // SA LE DECUPLEZI IN DEPLOYMENT SEPARATE
        $this->eventDispatcher->dispatch(new StockUpdatedEvent($productId, $stock->getItems()));
        //dupa 2 sprinturi dupa ce-ai pus in prod, schimbi cu
//        kafka/rabbit.send(
        $this->entityManager->persist($stock);
    }

    public function confirmReservation(int $orderId): void
    {
        $r = $this->entityManager->getRepository(StockReservation::class)->findOneBy(['orderId' => $orderId]);
        $this->entityManager->remove($r);
    }
}