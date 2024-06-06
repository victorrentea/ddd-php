<?php

namespace victor\training\modulith\catalog\in\rest;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Attribute\Route;
use victor\training\modulith\catalog\app\Product;
class GetProductApi
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    #[Route("/product/{productId}", methods: ["GET"])]
    public function getProductDetails(int $productId): GetProductResponse
    {
        $product = $this->entityManager->getRepository(Product::class)->find($productId);
//        $stock = ??
        return (new GetProductResponse())
            ->setId($product->getId())
            ->setName($product->getName())
            ->setDescription($product->getDescription())
            ->setPrice($product->getPrice())
            ->setStars($product->getStars());
    }
}
