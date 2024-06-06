<?php

namespace victor\training\modulith\order;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use victor\training\modulith\shipping\ShippingResultEvent;

class OrderService
{
    public function __construct(
        private EntityManager    $em,
        EventDispatcherInterface $eventDispatcher)
    {
        $eventDispatcher->addListener(ShippingResultEvent::class, [$this, 'onShippingResultEvent']);
    }

    public function onShippingResultEvent(ShippingResultEvent $event): Order
    {
        $order = $this->em->getRepository(Order::class)->find($event->orderId);
        $order->wasShipped($event->ok);
        $this->em->persist($order);
        $this->em->flush();
        return $order;
    }

}