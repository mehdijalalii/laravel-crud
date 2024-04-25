<?php

namespace Tests\Feature\Controllers\Customer\v1;

use Src\Customer\Presentation\API\V1\Requests\CustomerRequest;
use Tests\TestCase;

class CustomerRequestTest extends TestCase
{
    public $rules = null;
    public $validator = null;

    /**
     * Set up operations
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->rules     = (new CustomerRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    public function testValidateNumber()
    {
        $this->assertTrue($this->validateField('phone_number', '+989121234567'));
        $this->assertFalse($this->validateField('phone_number', '+982188776655'));
    }

    protected function validateField(string $field, $value): bool
    {
        return $this->validator->make(
            [$field => $value],
            [$field => $this->rules[$field]]
        )->passes();
    }
}
