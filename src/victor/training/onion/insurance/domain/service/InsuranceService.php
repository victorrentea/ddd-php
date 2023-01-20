<?php

namespace victor\training\onion\insurance\domain\service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use victor\training\onion\customer\domain\model\Customer;
use victor\training\onion\customer\domain\repo\CustomerRepo;
use victor\training\onion\insurance\domain\model\InsurancePolicy;
use victor\training\onion\insurance\domain\repo\InsurancePolicyRepo;

readonly class InsuranceService
{

    public function __construct(
       private InsurancePolicyRepo $insurancePolicyRepo,
        private CustomerRepo $customerRepo,
        private EventDispatcherInterface $dispatcher)
    {
//        $dispatcher->addListener('requote.customer', [$this, 'requoteCustomer']);
    }


    public function issuePolicy(int $customerId, string $customerName, int $address)
    {
        $policy = new InsurancePolicy($customerId);
        $policy->setCustomerName($customerName);
        $policy->setCustomerAddress($address);
        $this->insurancePolicyRepo->save($policy);
    }
    public function requoteCustomerOnAddressChanged(int $customerId, int $address)
    {
        $policy = $this->insurancePolicyRepo->findByCustomerId($customerId);
        if ($address === "Pakistan") {
            $policy->value += 100;
        }
    }




}