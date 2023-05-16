<?php

namespace Tests\Feature\Controllers\Customer\v1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Src\Customer\Application\UseCases\Commands\Update\UpdateCustomerCommand;
use Src\Customer\Infrastructure\Elequent\Models\Customer;
use Src\Customer\Presentation\API\V1\Controllers\UpdateCustomerController;
use Src\Shared\Domain\Bus\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateCustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    private UpdateCustomerController $controller;
    private MockInterface $commandBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = \Mockery::mock(CommandBusInterface::class);
        $this->controller = new \Src\Customer\Presentation\API\V1\Controllers\UpdateCustomerController($this->commandBus);
    }

    protected function tearDown(): void
    {
        \Mockery::close();

        parent::tearDown();
    }

    public function testUpdateCustomer(): void
    {
        $customer = Customer::factory()->create();

        $request = \Mockery::mock(\Src\Customer\Presentation\API\V1\Requests\CustomerRequest::class);
        $request->shouldReceive('all')->andReturn($customer->toArray());

        $this->commandBus->shouldReceive('dispatch')
            ->with(\Mockery::type(UpdateCustomerCommand::class))
            ->once()
            ->andReturnNull();

        $response = $this->controller->__invoke($request, $customer->id);

        $expectedData = [
            'customer' => [
                'id' => $customer->id
            ]
        ];

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame($expectedData, $response->getData(true));
    }
}
