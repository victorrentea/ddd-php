<?php

namespace victor\training\modulith\order;

class PaymentService
{
    public function generatePaymentUrl(int $orderId, float $total)
    {
        // payment gateway implementation details
        echo "Request payment url for order ui: " . $orderId;
        $gatewayUrl = "TODO";//$this->generatePaymentLink("order/" . $orderId . "/payment-accepted", $total, "modulith-app");
        return $gatewayUrl . "&orderId=" . $orderId;
    }
}