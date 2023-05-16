<?php

namespace Src\Customer\Application\Resources;

use Src\Customer\Domain\Customer;
use Src\Shared\Domain\Bus\Query\ResponseInterface;

final class CustomerResponse implements ResponseInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $date_of_birth,
        public readonly string $phone_number,
        public readonly string $email,
        public readonly string $bank_account_number
    ) {
    }

    public static function fromCustomer(Customer $customer): self
    {
        return new self(
            $customer->id->value,
            $customer->firstName->value,
            $customer->lastName->value,
            $customer->dateOfBirth->value,
            $customer->phoneNumber->value,
            $customer->email->value,
            $customer->bankAccountNumber->value
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->date_of_birth,
            'phone_number' => "+" . $this->phone_number,
            'email' => $this->email,
            'bank_account_number' => $this->bank_account_number
        ];
    }
}
