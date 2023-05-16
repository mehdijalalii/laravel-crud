<?php

namespace Src\Customer\Application\UseCases\Commands\Create;

use Src\Shared\Domain\Bus\Command\CommandInterface;

final class CreateCustomerCommand implements CommandInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $date_of_birth,
        public readonly string $email,
        public readonly int $bank_account_number,
        public readonly int $phone_number,
    )
    {}
}
