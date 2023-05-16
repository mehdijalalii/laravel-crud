<?php

namespace Src\Customer\Application\UseCases\Commands\Delete;

use Src\Shared\Domain\Bus\Command\CommandInterface;

final class DeleteCustomerByIdCommand implements CommandInterface
{
    public function __construct(public readonly string $id)
    {
    }
}
