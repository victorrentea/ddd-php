<?php
/**
 * Created by IntelliJ IDEA.
 * User: VictorRentea
 * Date: 9/19/2017
 * Time: 12:44 PM
 */

namespace victor\training\onion\application\service;


use Doctrine\ORM\EntityManager;
use victor\training\onion\application\dto\CustomerDto;
use victor\training\onion\application\dto\CustomerSearchCriteria;
use victor\training\onion\application\dto\CustomerSearchResult;
use victor\training\onion\domain\model\Customer;
use victor\training\onion\domain\model\ShippingAddress;
use victor\training\onion\domain\repo\CustomerRepo;
use victor\training\onion\domain\service\InsuranceService;

class CustomerApplicationService
{
    private CustomerRepo $customerRepository;
    private InsuranceService $insuranceService;
    private EntityManager $entityManager;

    public function __construct(CustomerRepo $customerRepository, InsuranceService $insuranceService, \Doctrine\ORM\EntityManager $entityManager)
    {
        $this->customerRepository = $customerRepository;
        $this->insuranceService = $insuranceService;
        $this->entityManager = $entityManager;
    }

    /** @return CustomerSearchResult[] */
    function search(CustomerSearchCriteria $searchCriteria): array
    {
        $q = $this->entityManager->createQueryBuilder()
            ->select("NEW CustomerSearchResult(c.id, c.name, c.email) FROM Customer c");

        if ($searchCriteria->getName())
            $q->where('c.name = :name')
                ->setParameter('name', $searchCriteria->getName());

        if ($searchCriteria->getEmail())
            $q->where('c.email = :email')
                ->setParameter('email', $searchCriteria->getEmail());

        return $q->getQuery()->getArrayResult();
    }

    function getCustomerById(int $customerId): CustomerDto
    {
        $customer = $this->customerRepository->findById($customerId);
        $dto = new CustomerDto();
        $dto->setName($customer->getName());
        $dto->setEmail($customer->getEmail());
        $dto->setAddress($customer->getAddress());
        $dto->setShippingAddressCity($customer->getShippingAddress()->city);
        $dto->setShippingAddressStreet($customer->getShippingAddress()->street);
        $dto->setShippingAddressZip($customer->getShippingAddress()->zip);
        return $dto;
    }


    function registerCustomer(CustomerDto $customerDto): CustomerDto
    {
        $customer = new Customer();
        $customer->setName($customerDto->getName());
        $customer->setEmail($customerDto->getEmail());
        $customer->setAddress($customerDto->getAddress());
        $customer->setShippingAddress(new ShippingAddress($customerDto->getShippingAddressCity(), $customerDto->getShippingAddressStreet(), $customerDto->getShippingAddressZip()));

        if (! $customer->getEmail()) {
            throw new \Exception("Bum");
        }

        // business logic
        // business logic
        // business logic
        // business logic
        $discountPercentage = $customer->getDiscount();
        echo "Biz logic with $discountPercentage";
        // business logic
        // business logic
        // business logic

        $this->insuranceService->requoteCustomer($customer);
    }

}