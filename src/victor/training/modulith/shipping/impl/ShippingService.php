<?php

namespace victor\training\modulith\shipping\impl;

class ShippingService
{
    public function requestShipment(int $orderId, string $customerAddress): string
    {
        echo "Request shipping at " . $customerAddress; // pretend HTTP request
        return "shipping_response";
    }
}