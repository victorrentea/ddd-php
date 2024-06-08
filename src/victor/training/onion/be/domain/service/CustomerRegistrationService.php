<?php

namespace victor\training\onion\be\domain\service;

use victor\training\onion\domain\model\Customer;

class CustomerRegistrationService
{

    public function register(Customer $customer): void
    {
        // business logic
        // business logic
        // business logic
        // business logic
        // business logic
        // business logic
        // business logic
        // business logic
        $discountPercentage = $customer->getDiscount();
        echo "Biz logic with $discountPercentage";
        // business logic
        // business logic
        // business logic
    }
}