<?php

namespace victor\training\modulith\inventory\interapi;

class StockIDto
{
    public function __construct(
        public readonly int $stock,
        public readonly int $productId)
    {
    }

}