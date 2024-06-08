<?php

namespace victor\training\modulith\inventory\interapi;

class StockUpdatedEvent
{
    public function __construct(
        public readonly int    $productId // "notification"
        // -> obliga listenerul sa faca ceva, un f()/GET

        , public readonly int $newQuantity // STATEFUL-event
    //callerul nu mai are nevoie sa cheme publisherul
    )
    {
    }

}