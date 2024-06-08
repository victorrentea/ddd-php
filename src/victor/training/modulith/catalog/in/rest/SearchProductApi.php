<?php

namespace victor\training\modulith\catalog\in\rest;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Annotation\Route;
use victor\training\modulith\catalog\app\Product;
use victor\training\modulith\inventory\interapi\InventoryInternalApi;

class SearchProductApi
{
    public function __construct(
        private EntityManager $entityManager,
        private InventoryInternalApi $inventoryInternalApi)
    {
    }
    #[Route("/product/search", methods: ["GET"])]
    public function searchProduct(
        string $name, int $page, int $size): array
    {

        // 100MB de RAM -> gunoi
//         $productIds = $this->inventoryInternalApi->getAllProductsInStock();

        $products = $this->entityManager->getRepository(Product::class)
            ->findBy(['name' => $name], null, $size, $page * $size);

        // pica produ pt ca faci N x GET /product/{ui} -> 1 x GET /product/{ui}
//        $products = array_filter($products,
//            fn(Product $product) => $this->inventoryInternalApi->isInStock($product->getId()));

        $this->inventoryInternalApi->isInStock(array_map(fn(Product $product) => $product->getId(), $products));

        // a) pui in catalog/Product#isInStock:boolean actualizat async prin Rabbit/Kafka
        // b) JOIN cu un VIEW expus de inventory

        return array_map(fn(Product $product) => (new GetProductResponse())
            ->setId($product->getId())
            ->setName($product->getName())
            ->setDescription($product->getDescription())
            ->setPrice($product->getPrice())
            ->setStars($product->getStars()), $products);
    }

}