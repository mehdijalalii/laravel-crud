<?php

namespace Src\Customer\Domain;

use Src\Shared\Domain\ValueObject\IntValueObject;

final class CustomerPhoneNumber extends IntValueObject
{
    public static function fromValue(string $phoneNumber): self
    {
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        return new self((int) $phoneNumber);
    }
}
