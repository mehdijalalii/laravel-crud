<?php

namespace Src\Customer\Application\Resources;

use Src\Customer\Domain\Customer;
use Src\Customer\Domain\Customers;
use Src\Shared\Domain\Bus\Query\ResponseInterface;

class CustomersResponse implements ResponseInterface
{
    /**
     * @param array<CustomersResponse> $customers
     */
    public function __construct(private readonly array $customers)
    {
    }

    public static function fromCustomers(Customers $customers): self
    {
        $customerResponses = array_map(
            function (Customer $customer) {
                return CustomerResponse::fromCustomer($customer);
            },
            $customers->all()
        );

        return new self($customerResponses);
    }

    public function jsonSerialize(): array
    {
        return array_map(function (CustomerResponse $customerResponse) {
            return $customerResponse->jsonSerialize();
        }, $this->customers);
    }
}
