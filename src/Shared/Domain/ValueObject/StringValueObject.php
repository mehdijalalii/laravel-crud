<?php

namespace Src\Shared\Domain\ValueObject;

abstract class StringValueObject
{
    public function __construct(public readonly string $value)
    {
    }

    public static function fromValue(string $value)
    {
        return new static($value);
    }
}
