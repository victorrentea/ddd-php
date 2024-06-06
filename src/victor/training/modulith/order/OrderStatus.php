<?php

namespace victor\training\modulith\order;

enum OrderStatus: string
{
    case AWAITING_PAYMENT="AWAITING_PAYMENT";
    case PAYMENT_FAILED = "PAYMENT_FAILED";
    case PAYMENT_APPROVED = "PAYMENT_APPROVED";
    case SHIPPING_IN_PROGRESS = "SHIPPING_IN_PROGRESS";
    case SHIPPING_FAILED = "SHIPPING_FAILED";
    case SHIPPING_COMPLETED = "SHIPPING_COMPLETED";

    public function requireOneOf(OrderStatus ...$allowedStatuses): void
    {
        if (!in_array($this, $allowedStatuses)) {
            throw new \InvalidArgumentException("Invalid status: " . $this->name);
        }
    }

}
