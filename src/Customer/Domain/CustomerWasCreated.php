<?php

namespace Src\Customer\Domain;

use Src\Shared\Domain\Bus\Event\AbstractDomainEvent;

final class CustomerWasCreated extends AbstractDomainEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $dateOfBirth,
        public readonly string $phoneNumber,
        public readonly string $email,
        public readonly string $bankAccountNumber,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): AbstractDomainEvent {
        return new self(
            $aggregateId,
            $body['firstName'],
            $body['lastName'],
            $body['dateOfBirth'],
            $body['phoneNumber'],
            $body['email'],
            $body['bankAccountNumber'],
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return 'Customer.was_created';
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'dateOfBirth' => $this->dateOfBirth,
            'phoneNumber' => $this->phoneNumber,
            'email' => $this->email,
            'bankAccountNumber' => $this->bankAccountNumber
        ];
    }
}
