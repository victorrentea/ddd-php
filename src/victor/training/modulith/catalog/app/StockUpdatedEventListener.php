<?php

namespace victor\training\modulith\catalog\app;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use victor\training\modulith\inventory\interapi\StockUpdatedEvent;

class StockUpdatedEventListener
{
    public function __construct(
        private readonly EntityManager    $entityManager
    )
    {
    }

    #[AsEventListener]
    public function onStockUpdated(StockUpdatedEvent $event)
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBy(['ui' => $event->productId]);
        $newV = $event->newQuantity > 0;
        $product->inStock = $newV;
        $this->entityManager->persist($product);
    }
}