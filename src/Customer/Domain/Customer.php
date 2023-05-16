<?php

namespace Src\Customer\Domain;

use Src\Shared\Domain\Aggregate\AggregateRoot;

final class Customer extends AggregateRoot
{
    public function __construct(
        public readonly CustomerId $id,
        public readonly CustomerFirstName $firstName,
        public readonly CustomerLastName $lastName,
        public readonly CustomerDateOfBirth $dateOfBirth,
        public readonly CustomerPhoneNumber $phoneNumber,
        public readonly CustomerEmail $email,
        public readonly CustomerBankAccountNumber $bankAccountNumber
    ) {
    }

    public static function fromPrimitives(
        string $id,
        string $firstName,
        string $lastName,
        string $dateOfBirth,
        string $phoneNumber,
        string $email,
        string $bankAccountNumber
    ): self {
        return new self(
            CustomerId::fromValue($id),
            CustomerFirstName::fromValue($firstName),
            CustomerLastName::fromValue($lastName),
            CustomerDateOfBirth::fromValue($dateOfBirth),
            CustomerPhoneNumber::fromValue($phoneNumber),
            CustomerEmail::fromValue($email),
            CustomerBankAccountNumber::fromValue($bankAccountNumber)
        );
    }

    public static function create(
        CustomerId $id,
        CustomerFirstName $firstName,
        CustomerLastName $lastName,
        CustomerDateOfBirth $dateOfBirth,
        CustomerEmail $email,
        CustomerBankAccountNumber $bankAccountNumber,
        CustomerPhoneNumber $phoneNumber
    ): self {
        $customer = new self(
            $id,
            $firstName,
            $lastName,
            $dateOfBirth,
            $phoneNumber,
            $email,
            $bankAccountNumber
        );

        $customer->record(new CustomerWasCreated(
            $id->value,
            $firstName->value,
            $lastName->value,
            $dateOfBirth->value,
            $phoneNumber->value,
            $email->value,
            $bankAccountNumber->value
        ));

        return $customer;
    }
}
