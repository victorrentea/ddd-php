<?php
/**
 * Created by IntelliJ IDEA.
 * User: VictorRentea
 * Date: 9/19/2017
 * Time: 12:44 PM
 */

namespace victor\training\onion\be\application\service;


use Symfony\Component\Routing\Annotation\Route;
use victor\training\onion\be\application\ui\dto\CustomerDto;
use victor\training\onion\be\application\ui\dto\CustomerSearchResult;
use victor\training\onion\be\domain\repo\CustomerRepo;
use victor\training\onion\be\domain\service\CustomerRegistrationService;
use victor\training\onion\be\domain\service\InsuranceService;
use victor\training\onion\be\input\ui\dto\CustomerSearchCriteria;
use victor\training\onion\domain\model\Customer;

class CustomerApplicationService /*implements CustomerApplicationServiceInterface*/
{

    public function __construct(
        private CustomerRepo $customerRepository,
        private InsuranceService $insuranceService,
        private CustomerRegistrationService $customerRegistrationService,
        private \Doctrine\ORM\EntityManager $entityManager)
    {
    }

    /** @return CustomerSearchResult[] */
    function search(CustomerSearchCriteria $searchCriteria): array
    {
        $q = $this->entityManager->createQueryBuilder()
            ->select("NEW CustomerSearchResult(c.ui, c.name, c.email) FROM Customer c");

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

    #[Route("/customer/register")]
//    #[Operation(summary: "Register a new customer")]
    function registerCustomer(CustomerDto $customerDto): CustomerDto
    {
        $customer = $customerDto->toEntity();
        $this->customerRegistrationService->register($customer);
        $this->insuranceService->requoteCustomer($customer);
    }


}