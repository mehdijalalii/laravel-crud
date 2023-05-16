<?php

namespace Src\Customer\Domain;

use Src\Shared\Domain\DomainException;
use Throwable;

final class CustomerNotFound extends DomainException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "" === $message ? "Customer not found" : $message;

        parent::__construct($message, $code, $previous);
    }
}
