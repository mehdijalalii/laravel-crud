<?php

namespace Src\Customer\Domain;

use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;

final class CustomerFinder
{
    public function __construct(private CustomerRepositoryInterface $repository)
    {
    }

    /**
     * @throws CustomerNotFound
     */
    public function __invoke(CustomerId $id): Customer
    {
        $customer = $this->repository->findOneBy(new Criteria([
            new Filter(
                'id',
                FilterOperator::EQUAL,
                $id->value
            )
        ]));

        return $customer;
    }
}
