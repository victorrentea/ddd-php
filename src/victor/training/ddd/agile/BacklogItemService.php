<?php

namespace victor\training\ddd\agile;

class BacklogItemService
{
    private BacklogItemRepo $backlogItemRepo;
    private ProductRepo $productRepo;

    public function __construct(BacklogItemRepo $backlogItemRepo, ProductRepo $productRepo)
    {
        $this->backlogItemRepo = $backlogItemRepo;
        $this->productRepo = $productRepo;
    }

    public function createBacklogItem(BacklogItemDto $dto): int
    {
        $product = $this->productRepo->findOneById($dto->productId);
        $backlogItem = (new BacklogItem($product, $dto->title, $dto->description))
            ->setProduct($product)
            ->setDescription($dto->description)
            ->setTitle($dto->title);
        $product->addBacklogItem($backlogItem);

        return $this->backlogItemRepo->save($backlogItem)->getId();
    }

    public function getBacklogItem(int $id): BacklogItemDto
    {
        $backlogItem = $this->backlogItemRepo->findOneById($id);
        $dto = new BacklogItemDto();
        $dto->id = $backlogItem->getId();
        $dto->productId = $backlogItem->getProduct()->getId();
        $dto->description = $backlogItem->getDescription();
        $dto->title = $backlogItem->getTitle();
        $dto->version = $backlogItem->getVersion();
        return $dto;
    }

    public function updateBacklogItem(BacklogItemDto $dto): void
    {
        $backlogItem = (new BacklogItem())
            ->setId($dto->id)
            ->setProduct($this->productRepo->findOneById($dto->productId))
            ->setDescription($dto->description)
            ->setTitle($dto->title)
            ->setVersion($dto->version);
        $this->backlogItemRepo->save($backlogItem);
    }

    public function deleteBacklogItem(int $id): void
    {
        $this->backlogItemRepo->deleteById($id);
    }
}