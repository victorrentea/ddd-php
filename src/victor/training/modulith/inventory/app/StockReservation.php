<?php

namespace victor\training\modulith\inventory\app;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class StockReservation
{
    #[Id]
    #[GeneratedValue]
    private int $id;
    #[Column]
    private int $orderId;
    #[Column]
    private int $productId;
    #[Column]
    private int $items;
    #[Column]
    private \DateTime $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): StockReservation
    {
        $this->id = $id;
        return $this;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): StockReservation
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): StockReservation
    {
        $this->productId = $productId;
        return $this;
    }

    public function getItems(): int
    {
        return $this->items;
    }

    public function setItems(int $items): StockReservation
    {
        $this->items = $items;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): StockReservation
    {
        $this->createdAt = $createdAt;
        return $this;
    }


}