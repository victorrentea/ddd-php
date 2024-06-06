<?php

namespace victor\training\modulith\shipping;

class ShippingResultEvent
{
    public function __construct(public string $orderId, public bool $ok)
    {
    }

}