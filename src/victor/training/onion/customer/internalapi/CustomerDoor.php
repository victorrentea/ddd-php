<?php

namespace victor\training\onion\customer\internalapi;

use victor\training\onion\customer\domain\repo\CustomerRepo;
use victor\training\onion\customer\internalapi\ddo\CustomerKnob;

readonly class CustomerDoor
{
    public function __construct(private CustomerRepo $customerRepo)
    {
    }

    public function getCustomerById(int $customerId):CustomerKnob
    {
        $customer = $this->customerRepo->findById($customerId);
        return new CustomerKnob($customerId->id, $customer->getName(), $customer->getAddress());
    }
}