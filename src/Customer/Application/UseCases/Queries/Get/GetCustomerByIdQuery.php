<?php

namespace Src\Customer\Application\UseCases\Queries\Get;

use Src\Shared\Domain\Bus\Query\QueryInterface;

final class GetCustomerByIdQuery implements QueryInterface
{
    public function __construct(public readonly string $id)
    {
    }
}
