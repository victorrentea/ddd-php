<?php

namespace victor\training\modulith\shipping\impl;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use victor\training\modulith\shipping\ShippingResultEvent;

class ShippingProviderWebHookApi
{
    public function __construct(private EventDispatcherInterface $eventDispatcher)
    {
    }
    public function shippedStatus(int $orderId, bool $ok): string
    {
        //called back by shipping
        $this->eventDispatcher->dispatch(new ShippingResultEvent($orderId, $ok));
        return "Shipping callback received";
    }

}