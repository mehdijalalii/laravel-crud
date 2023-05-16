<?php

namespace Src\Customer\Application\UseCases\Subscriber;

use Src\Customer\Domain\CustomerWasCreated;
use Src\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class SomethingWithCreatedCustomerSubscriber implements DomainEventSubscriberInterface
{
    public function __invoke(CustomerWasCreated $event): void
    {
        // TODO add here some logic in relation with the event
    }

    public static function subscribedTo(): array
    {
        return [
            CustomerWasCreated::class
        ];
    }
}
