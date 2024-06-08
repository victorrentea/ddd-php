<?php

namespace victor\training\onion\be\domain\service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use victor\training\onion\be\domain\repo\InsurancePolicyRepo;
use victor\training\onion\domain\model\Customer;

class InsuranceService
{

    public function __construct(
        private InsurancePolicyRepo $insurancePolicyRepo,
        EventDispatcherInterface $dispatcher)
    {
//        $dispatcher->addListener('requote.customer', [$this, 'requoteCustomer']);
    }


    public function requoteCustomer(Customer $command)
    {
        $policy = $this->insurancePolicyRepo->findByCustomerId($command->customerId);
        if ($command->newAddress === "Pakistan") {
            $policy->value += 100;
        }
    }

    function displayPolicy(int $id): string
    {
        $policy = $this->insurancePolicyRepo->findId($id);
        $customerName = $policy->customer->name;
        $address = $policy->customer->address;
        return "Some result about $customerName and $address";
    }
}