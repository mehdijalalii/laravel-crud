<?php

namespace Tests\Feature\Controllers\Customer\v1;

use Illuminate\Http\Request;
use Mockery;
use Src\Customer\Application\Resources\CustomersResponse;
use Src\Customer\Application\UseCases\Queries\Get\GetCustomerByIdQuery;
use Src\Customer\Infrastructure\Elequent\Models\Customer;
use Src\Customer\Presentation\API\Resources\v1\CustomerResource;
use Src\Shared\Domain\Bus\Query\QueryBusInterface;
use Tests\TestCase;

class GetCustomerByIdControllerTest extends TestCase
{
    private $queryBus;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->queryBus = Mockery::mock(QueryBusInterface::class);
        $this->controller = new \Src\Customer\Presentation\API\V1\Controllers\GetCustomerByIdController($this->queryBus);
    }

    public function testGetCustomerById(): void
    {
        $request = Mockery::mock(Request::class);

        $customerResponse = new CustomersResponse($customer = Customer::factory()->make()->toArray());

        $expectedJsonResponse = response()->json([
            'customer' => (array) $customerResponse
        ]);

        $this->queryBus
            ->shouldReceive('ask')
            ->once()
            ->with(Mockery::on(function (GetCustomerByIdQuery $query) use ($customer) {
                return $query->id === $customer['id'];
            }))
            ->andReturn($customerResponse);

        $response = $this->controller->__invoke($request, $customer['id']);

        $this->assertEquals($expectedJsonResponse, $response);
    }
}
