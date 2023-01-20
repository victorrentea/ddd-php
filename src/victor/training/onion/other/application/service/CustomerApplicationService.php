<?php
/**
 * Created by IntelliJ IDEA.
 * User: VictorRentea
 * Date: 9/19/2017
 * Time: 12:44 PM
 */

namespace victor\training\onion\other\application\service;


use victor\training\onion\other\application\dto\CustomerDto;
use victor\training\onion\other\application\dto\CustomerSearchCriteria;
use victor\training\onion\other\application\dto\CustomerSearchResult;
use victor\training\onion\other\domain\model\Customer;
use victor\training\onion\other\domain\repo\CustomerRepo;
use victor\training\onion\other\domain\service\InsuranceService;
use victor\training\onion\other\domain\service\RegisterCustomerService;

class CustomerApplicationService
{
    public function __construct(private CustomerRepo $customerRepository,
                                private InsuranceService $insuranceService,
                                private RegisterCustomerService $registerCustomerService
    )
    {
    }

    /** @return CustomerSearchResult[] */
    function search(CustomerSearchCriteria $searchCriteria): array
    {
        return $this->customerRepository->search($searchCriteria);
    }

    function getCustomerById(int $customerId): CustomerDto
    {
        $customer = $this->customerRepository->findById($customerId);

//        $dto = $customer->toDto(); // NU incalci Dependecy Rule: cuplezi ce-ai mai sfant (Domain Modelul) cu API concerns

        $dto = new Customer($customer);
         // sau :
//        $dto = CustomerDto::fromCustomer($customer);

        return $dto;
    }

    function registerCustomer(CustomerDto $customerDto): CustomerDto
    {
        $customer = new Customer();
        $customer->setName($customerDto->getName());
        $customer->setEmail($customerDto->getEmail());
        $customer->setAddress($customerDto->getAddress());

        if (! $customer->getEmail()) {
            throw new \Exception("Bum");
        }

        $this->registerCustomerService->register($customer);
//        $customer->register();

        $this->insuranceService->requoteCustomer($customer);
    }

}