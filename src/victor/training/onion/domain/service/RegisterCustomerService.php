<?php

namespace victor\training\onion\domain\service;

use victor\training\onion\domain\model\Customer;

class RegisterCustomerService
{
/// TODO dependinte injectate de DI
    function register(Customer $customer) {
        // business logic
        // business logic creste mare
        // business logic
        // business logic

        $discountPercentage = $customer->getDiscountPercentage();

        echo "Biz logic with $discountPercentage";
        // business logic
        // business logic
        // business logic

    }

}