<?php

namespace victor\training\modulith\catalog\in\rest\internal;

use Doctrine\ORM\EntityManager;
use victor\training\modulith\catalog\app\Product;

class CatalogInternalApi implements CatalogInternalApiInterface
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function getManyPrices(array $ids): array {
        $productRepo = $this->entityManager->getRepository(Product::class);
        $products = $productRepo->findAllById($ids);
        $result = [];
        foreach ($products as $product) {
            $result[$product->getId()] = $product->getPrice();
        }
        return $result;
    }

}