<?php

namespace Src\Customer\Application\UseCases\Commands\Delete;

use Illuminate\Support\Facades\Log;
use Src\Customer\Domain\CustomerDeleter;
use Src\Customer\Domain\CustomerId;
use Src\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class DeleteCustomerByIdCommandHandler implements CommandHandlerInterface
{
    public function __construct(private CustomerDeleter $deletor)
    {
    }

    public function __invoke(DeleteCustomerByIdCommand $command): void
    {
        $id = CustomerId::fromValue($command->id);

        $this->deletor->__invoke($id);
    }
}
