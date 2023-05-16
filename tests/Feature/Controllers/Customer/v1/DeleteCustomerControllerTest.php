<?php

namespace Tests\Feature\Controllers\Customer\v1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Customer\Infrastructure\Elequent\Models\Customer;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeleteCustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteCustomer(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->delete(route('deleteCustomer', $customer->id));

        $this->assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $this->assertModelMissing($customer);
    }
}
