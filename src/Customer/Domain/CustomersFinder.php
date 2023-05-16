<?php

namespace Src\Customer\Domain;

use Src\Shared\Domain\Criteria\Criteria;

final class CustomersFinder
{
    public function __construct(private CustomerRepositoryInterface $repository)
    {
    }

    public function __invoke(Criteria $criteria): Customers
    {
        return $this->repository->findBy($criteria);
    }
}
