<?php

namespace Src\Shared\Domain\ValueObject;

use DateTimeImmutable;

abstract class DateValueObject extends StringValueObject
{
    protected function __construct(string $value)
    {
        $this->ensureValidDateFormat($value);
        parent::__construct($value);
    }

    private function ensureValidDateFormat(string $value): void
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $value);
        $formattedValue = $date !== false ? $date->format('Y-m-d') : null;

        if ($formattedValue !== $value) {
            throw new \InvalidArgumentException('Invalid date format');
        }
    }

    public static function fromValue(string $value): static
    {
        return new static($value);
    }
}
