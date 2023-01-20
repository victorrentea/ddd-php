<?php

namespace victor\training\onion\insurance\application\service;

use victor\training\onion\customer\internalapi\CustomerDoor;
use victor\training\onion\insurance\domain\repo\InsurancePolicyRepo;

readonly class InsuranceApplicationService
{

    public function __construct(
        private InsurancePolicyRepo $insurancePolicyRepo,
//        private CustomerRepo $customerRepo
        private CustomerDoor $customerDoor
    )
    {
    }

    function displayPolicy(int $id): string
    {
        $policy = $this->insurancePolicyRepo->findById($id);
        // gresit pt ca imi expune parti din Domain celuilalt modul
//        $customer = $this->customerRepo->findById($policy->getCustomerId());

        $customerKnob = $this->customerDoor->getCustomerById($policy->getCustomerId());
        $customerName = $customerKnob->name;
        $address = $customerKnob->address;
        return "Some result about $customerName and $address ". $policy->getValueInEur();
    }
}