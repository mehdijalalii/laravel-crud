<?php

namespace Tests\Feature\Controllers\Customer\v1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Customer\Application\UseCases\Commands\Create\CreateCustomerCommand;
use Src\Customer\Infrastructure\Elequent\Models\Customer;
use Src\Customer\Presentation\API\V1\Requests\CustomerRequest;
use Src\Shared\Domain\Bus\Command\CommandBusInterface;
use Src\Shared\Domain\UuidGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateCustomerControllerTest extends TestCase
{
    use RefreshDatabase;
    private $commandBus;
    private $uuidGenerator;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = $this->createMock(CommandBusInterface::class);
        $this->uuidGenerator = $this->createMock(UuidGeneratorInterface::class);
        $this->controller = new \Src\Customer\Presentation\API\V1\Controllers\CreateCustomerController($this->commandBus, $this->uuidGenerator);
    }

    public function testCreateCustomerWithValidRequest()
    {
        $customerData = Customer::factory()->make()->toArray();
        $customerData['phone_number'] = (int) $customerData['phone_number'];
        $request = new CustomerRequest($customerData);

        $this->uuidGenerator->method('generate')
            ->willReturn($customerData['id']);

        $this->commandBus->expects($this->once())->method('dispatch')->with(
            $this->equalTo(new CreateCustomerCommand(
                $customerData['id'],
                $customerData['first_name'],
                $customerData['last_name'],
                $customerData['date_of_birth'],
                $customerData['email'],
                $customerData['bank_account_number'],
                $customerData['phone_number']
            ))
        );

        $response = $this->controller->__invoke($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(['customer' => ['id' => $customerData['id']]], $responseData);
    }
}
