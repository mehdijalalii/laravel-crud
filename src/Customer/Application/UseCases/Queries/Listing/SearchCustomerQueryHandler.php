<?php

namespace Src\Customer\Application\UseCases\Queries\Listing;

use Src\Customer\Application\Resources\CustomersResponse;
use Src\Customer\Domain\CustomersFinder;
use Src\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Src\Shared\Domain\Criteria\Criteria;

final class SearchCustomerQueryHandler implements QueryHandlerInterface
{
    public function __construct(private CustomersFinder $finder)
    {
    }

    public function __invoke(SearchCustomersQuery $query): CustomersResponse
    {
        $criteria = new Criteria(
            [], // TODO
            [], // TODO
            $query->offset,
            $query->limit
        );

        $customers = $this->finder->__invoke($criteria);

        return CustomersResponse::fromCustomers($customers);
    }
}
