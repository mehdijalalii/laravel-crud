<?php

namespace Src\Customer\Domain;

use Src\Shared\Domain\Criteria\Criteria;

interface CustomerRepositoryInterface
{
    public function delete(CustomerId $id): void;

    public function findBy(Criteria $criteria): Customers;

    public function findOneBy(Criteria $criteria): ?Customer;

    public function save(Customer $customer): void;
}
