<?php

namespace Src\Customer\Domain;

use Src\Shared\Domain\Bus\Event\EventBusInterface;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;

final class CustomerCreator
{
    public function __construct(
        private CustomerRepositoryInterface $repository,
        private EventBusInterface           $eventBus
    ) {
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

        if ($customer !== null) {
            throw new CustomerAlreadyExists();
        }

        $customer = Customer::create($id, $firstName, $lastName, $dateOfBirth, $email, $bankAccountNumber, $phoneNumber);
        $this->repository->save($customer);
        $this->eventBus->publish(...$customer->pullDomainEvents());
    }
}
