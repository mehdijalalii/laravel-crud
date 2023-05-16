<?php

namespace Src\Customer\Application\UseCases\Commands\Create;

use Src\Customer\Domain\CustomerBankAccountNumber;
use Src\Customer\Domain\CustomerCreator;
use Src\Customer\Domain\CustomerDateOfBirth;
use Src\Customer\Domain\CustomerEmail;
use Src\Customer\Domain\CustomerId;
use Src\Customer\Domain\CustomerFirstName;
use Src\Customer\Domain\CustomerLastName;
use Src\Customer\Domain\CustomerPhoneNumber;
use Src\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CreateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(private CustomerCreator $creator) {
    }

    public function __invoke(CreateCustomerCommand $command): void
    {
        $id = CustomerId::fromValue($command->id);
        $firstName = CustomerFirstName::fromValue($command->first_name);
        $lastName = CustomerLastName::fromValue($command->last_name);
        $dateOfBirth = CustomerDateOfBirth::fromValue($command->date_of_birth);
        $email = CustomerEmail::fromValue($command->email);
        $bankAccountNumber = CustomerBankAccountNumber::fromValue($command->bank_account_number);
        $phoneNumber = CustomerPhoneNumber::fromValue($command->phone_number);

        $this->creator->__invoke($id, $firstName, $lastName, $dateOfBirth, $email, $bankAccountNumber, $phoneNumber);
    }
}
