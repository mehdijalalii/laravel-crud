<?php

namespace Src\Customer\Application\UseCases\Commands\Update;

use Src\Customer\Domain\CustomerBankAccountNumber;
use Src\Customer\Domain\CustomerDateOfBirth;
use Src\Customer\Domain\CustomerEmail;
use Src\Customer\Domain\CustomerId;
use Src\Customer\Domain\CustomerFirstName;
use Src\Customer\Domain\CustomerLastName;
use Src\Customer\Domain\CustomerPhoneNumber;
use Src\Customer\Domain\CustomerUpdater;
use Src\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class UpdateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(private CustomerUpdater $updater)
    {
    }

    public function __invoke(UpdateCustomerCommand $command): void
    {
        $id = CustomerId::fromValue($command->id);
        $firstName = CustomerFirstName::fromValue($command->first_name);
        $lastName = CustomerLastName::fromValue($command->last_name);
        $dateOfBirth = CustomerDateOfBirth::fromValue($command->date_of_birth);
        $email = CustomerEmail::fromValue($command->email);
        $bankAccountNumber = CustomerBankAccountNumber::fromValue($command->bank_account_number);
        $phoneNumber = CustomerPhoneNumber::fromValue($command->phone_number);

        $this->updater->__invoke($id, $firstName, $lastName, $dateOfBirth, $email, $bankAccountNumber, $phoneNumber);
    }
}
