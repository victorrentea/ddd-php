<?php

namespace victor\training\modulith\order;

use victor\training\modulith\shared\LineItem;

class PlaceOrderRequest
{
    public string $customerId;
    /**
     * @var LineItem[]
     */
    public array $lineItems;
    public string $shippingAddress;
}