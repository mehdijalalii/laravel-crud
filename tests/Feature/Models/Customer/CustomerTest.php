<?php

namespace Tests\Feature\Models\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Customer\Infrastructure\Elequent\Models\Customer;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function testInsertData()
    {
        $customer = Customer::factory()->create();

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertDatabaseHas('customers', $customer->toArray());
    }
}
