<?php

namespace victor\training\modulith\shipping;

use victor\training\modulith\shipping\impl\ShippingService;

class ShippingInternalApi
{
    public function __construct(private ShippingService $shippingService)
    {
    }

    public function requestShipment(int $orderId, string $customerAddress): string
    {
        return $this->shippingService->requestShipment($orderId, $customerAddress);
    }
}