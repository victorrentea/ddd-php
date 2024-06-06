<?php

namespace victor\training\modulith\order;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use victor\training\modulith\inventory\InventoryInternalApi;
use victor\training\modulith\shipping\ShippingInternalApi;
use victor\training\modulith\shipping\ShippingResultEvent;

class PaymentGatewayWebHookApi
{
    public function __construct(
        private EntityManager $entityManager,
        private ShippingInternalApi $shippingInternalApi,
        private InventoryInternalApi $inventoryInternalApi
    ) { }

    #[Route("/payment/{orderId}/status", methods: ["PUT"])]
    public function confirmPayment(
            int $orderId,
            #[MapRequestPayload] PaymentGatewayCallbackRequest $request) {

        $order = $this->entityManager->find(Order::class, $orderId);
        $order->pay($request->ok);

        if ($order->status() == OrderStatus::PAYMENT_APPROVED) {
            $this->inventoryInternalApi->confirmReservation($order->id());
            $trackingNumber = $this->shippingInternalApi->requestShipment($order->id(), $order->shippingAddress());
            $order->wasScheduleForShipping($trackingNumber);
        }
        $this->entityManager->persist($order);
    }

}