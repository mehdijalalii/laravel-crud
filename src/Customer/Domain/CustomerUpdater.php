<?php

namespace Src\Customer\Domain;

use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;

final class CustomerUpdater
{
    public function __construct(private CustomerRepositoryInterface $repository)
    {
    }

    public function __invoke(
        CustomerId $id,
        CustomerFirstName $firstName,
        CustomerLastName $lastName,
        CustomerDateOfBirth $dateOfBirth,
        CustomerEmail $email,
        CustomerBankAccountNumber $bankAccountNumber,
        CustomerPhoneNumber $phoneNumber
    ): void
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

        $customer = Customer::fromPrimitives(
            $id->value,
            $firstName->value,
            $lastName->value,
            $dateOfBirth->value,
            $phoneNumber->value,
            $email->value,
            $bankAccountNumber->value,
        );

        $this->repository->save($customer);
    }
}
