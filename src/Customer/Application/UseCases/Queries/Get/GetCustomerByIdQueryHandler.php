<?php

namespace Src\Customer\Application\UseCases\Queries\Get;

use Src\Customer\Application\Resources\CustomerResponse;
use Src\Customer\Domain\CustomerFinder;
use Src\Customer\Domain\CustomerId;
use Src\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class GetCustomerByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private CustomerFinder $finder)
    {
    }

    public function __invoke(GetCustomerByIdQuery $query): CustomerResponse
    {
        $id = CustomerId::fromValue($query->id);

        $customer = $this->finder->__invoke($id);

        return CustomerResponse::fromCustomer($customer);
    }
}
