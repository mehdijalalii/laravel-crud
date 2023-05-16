<?php

namespace Src\Customer\Domain;

use Src\Shared\Domain\AbstractCollection;

final class Customers extends AbstractCollection
{
    protected function type(): string
    {
        return Customer::class;
    }
}
