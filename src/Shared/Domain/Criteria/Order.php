<?php

namespace Src\Shared\Domain\Criteria;

class Order
{
    public function __construct(
        public readonly OrderType $orderType,
        public readonly string $orderBy
    ) {
    }
}
