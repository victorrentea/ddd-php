<?php

namespace victor\training\modulith\order;

use victor\training\modulith\common\LineItem;

class PlaceOrderRequest
{
    public string $customerId;
    /**
     * @var LineItem[]
     */
    public array $lineItems;
    public string $shippingAddress;
}