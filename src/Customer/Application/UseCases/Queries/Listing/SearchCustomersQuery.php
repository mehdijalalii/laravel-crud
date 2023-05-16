<?php

namespace Src\Customer\Application\UseCases\Queries\Listing;

use Src\Shared\Domain\Bus\Query\QueryInterface;

final class SearchCustomersQuery implements QueryInterface
{
    public function __construct(
        public readonly ?array $filters = null,
        public readonly ?array $orderList = null,
        public readonly ?int $offset = null,
        public readonly ?int $limit = null
    ) {
    }
}
