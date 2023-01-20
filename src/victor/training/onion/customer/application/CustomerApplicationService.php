<?php

namespace victor\training\onion\customer\application;

use victor\training\onion\customer\domain\model\Customer;

class CustomerApplicationService
{

    // PUT /customer/{id}/address // 3
    // POST /update-customer // 2
    function updateAddress(int $customerId)
    {
        // publishEvent(new CustomerAddressChangedEvent(customerId, newAddress))
    }
    // PUT /customer/{id}  // 1
    function update(Customer $customer)
    {
//        $oldCustomer =.
//        if ($oldCustomer->getAddress() != $customer->getAddress() ) {
//            //
//        }

    }

}