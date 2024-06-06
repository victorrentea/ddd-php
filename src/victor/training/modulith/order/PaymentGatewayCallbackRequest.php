<?php

namespace victor\training\modulith\order;

class PaymentGatewayCallbackRequest
{
    public function __construct(public string $orderId, public bool $ok)
    {
    }

}