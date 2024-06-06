<?php

namespace victor\training\modulith\order;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Annotation\Route;
use victor\training\modulith\catalog\in\internal\CatalogInternalApi;
use victor\training\modulith\inventory\InventoryInternalApi;
use victor\training\modulith\shipping\ShippingResultEvent;

class PlaceOrderApi
{

    public function __construct(private EntityManager        $entityManager,
                                private CatalogInternalApi   $catalogInternalApi,
                                private InventoryInternalApi $inventoryInternalApi,
                                private PaymentService       $paymentService,
                                EventDispatcherInterface $dispatcher)
    {
        $dispatcher->addListener('shipping.result', [$this, 'onShippingResultEvent']);
    }


    #[Route("/order", methods: ["POST"])]
    public function placeOrder(PlaceOrderRequest $request): string
    {
        $productIds = array_map(fn($item) => $item->getProductId(), $request->lineItems);
        $prices = $this->catalogInternalApi->getManyPrices($productIds);
        $items = [];
        $totalPrice = 0;
        foreach ($request->lineItems as $item) {
            $items[$item->getProductId()] = $item->getCount();
            $totalPrice += $item->getCount() * $prices[$item->getProductId()];
        }
        $order = (new Order())
            ->setItems($items)
            ->setShippingAddress($request->shippingAddress)
            ->setCustomerId($request->customerId)
            ->setTotal($totalPrice);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->inventoryInternalApi->reserveStock($order->getId(), $request->lineItems);
        return $this->paymentService->generatePaymentUrl($order->getId(), $order->getTotal());
    }

    public function onShippingResultEvent(ShippingResultEvent $event): void
    {
        $order = $this->entityManager->find(Order::class, $event->orderId);
        $order->shipped($event->ok);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}