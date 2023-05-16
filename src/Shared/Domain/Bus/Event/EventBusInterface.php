<?php

namespace Src\Shared\Domain\Bus\Event;

interface EventBusInterface
{
    public function publish(AbstractDomainEvent ...$events): void;
}
