<?php

namespace victor\training\onion\domain\service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use victor\training\onion\domain\model\Customer;
use victor\training\onion\domain\repo\CustomerRepo;
use victor\training\onion\domain\repo\InsurancePolicyRepo;

class InsuranceService
{
    private InsurancePolicyRepo $insurancePolicyRepo;
    private CustomerRepo $customerRepo;
    private EventDispatcherInterface $dispatcher;

    public function __construct(InsurancePolicyRepo $insurancePolicyRepo, CustomerRepo $customerRepo, EventDispatcherInterface $dispatcher)
    {
        $this->insurancePolicyRepo = $insurancePolicyRepo;
        $this->customerRepo = $customerRepo;
        $this->dispatcher = $dispatcher;

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