<?php

namespace victor\training\modulith\common;

class LineItem
{

    public function __construct(private int $productId, private int $count)
    {
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}