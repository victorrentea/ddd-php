<?php

namespace victor\training\modulith\catalog\in\rest;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Annotation\Route;
use victor\training\modulith\catalog\app\Product;

class SearchProductApi
{
    public function __construct(private EntityManager $entityManager)
    {
    }
    #[Route("/product/search", methods: ["GET"])]
    public function searchProduct(string $name, int $page, int $size): array
    {
        $products = $this->entityManager->getRepository(Product::class)
            ->findBy(['name' => $name], null, $size, $page * $size);
        return array_map(fn(Product $product) => (new GetProductResponse())
            ->setId($product->getId())
            ->setName($product->getName())
            ->setDescription($product->getDescription())
            ->setPrice($product->getPrice())
            ->setStars($product->getStars()), $products);
    }

}