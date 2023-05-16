<?php

namespace Src\Customer\Domain;

use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;

final class CustomerDeleter
{
    public function __construct(private CustomerRepositoryInterface $repository)
    {
    }

    public function __invoke(CustomerId $id): void
    {
        $customer = $this->repository->findOneBy(new Criteria([
            new Filter(
                'id',
                FilterOperator::EQUAL,
                $id->value
            )
        ]));

        if (null === $customer) {
            throw new CustomerNotFound();
        }

        $this->repository->delete($id);
    }
}
