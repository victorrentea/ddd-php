<?php

namespace victor\training\modulith\catalog\in\rest;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Attribute\Route;
use victor\training\modulith\catalog\app\Product;
use victor\training\modulith\inventory\interapi\InventoryInternalApi;

class GetProductApi
{
    public function __construct(
        private readonly EntityManager $entityManager,
        private readonly InventoryInternalApi $inventoryInternalApi
    ) {}

    #[Route("/product/{productId}", methods: ["GET"])]
    public function getProductDetails(int $productId): GetProductResponse
    {
        $product = $this->entityManager->getRepository(Product::class)
            ->find($productId);
        $stock = $this->inventoryInternalApi->getStockByProduct($productId);
        return (new GetProductResponse())
            ->setId($product->getId())
            ->setStock($stock->stock)
            ->setName($product->getName())
            ->setDescription($product->getDescription())
            ->setPrice($product->getPrice())
            ->setStars($product->getStars());
    }
}
