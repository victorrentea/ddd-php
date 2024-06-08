<?php
/**
 * Created by IntelliJ IDEA.
 * User: VictorRentea
 * Date: 9/19/2017
 * Time: 12:42 PM
 */

namespace victor\training\onion\be\domain\repo;


use victor\training\onion\be\application\ui\dto\CustomerSearchResult;
use victor\training\onion\be\input\ui\dto\CustomerSearchCriteria;
use victor\training\onion\domain\model\Customer;

interface CustomerRepo
{
    public function findById(int $customerId): Customer;

    /** @return CustomerSearchResult[] */
    public function search(CustomerSearchCriteria $searchCriteria): array;
}