<?php

namespace victor\training\modulith\inventory\app;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Stock
{
    // id, productId, items
    #[Id]
    #[GeneratedValue]
    private int $id;
    #[Column]
    private int $productId;
    #[Column]
    private int $items;

    public function remove(int $itemsRemoved): Stock
    {
        if ($itemsRemoved <= 0) {
            throw new \InvalidArgumentException("Negative: " . $itemsRemoved);
        }
        if ($itemsRemoved > $this->items) {
            throw new \InvalidArgumentException("Not enough stock to remove: " . $itemsRemoved);
        }
        $this->items -= $itemsRemoved;
        return $this;
    }

    public function add(int $itemsAdded): Stock
    {
        if ($itemsAdded <= 0) {
            throw new \InvalidArgumentException("Negative: " . $itemsAdded);
        }
        $this->items += $itemsAdded;
        return $this;
    }

}