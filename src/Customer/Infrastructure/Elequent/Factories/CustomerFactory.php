<?php

namespace Src\Customer\Infrastructure\Elequent\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Customer\Infrastructure\Elequent\Models\Customer;

final class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => fake()->uuid(),
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'date_of_birth' => fake()->date('Y-m-d'),
            'email' => fake()->email,
            'bank_account_number' => fake()->numerify('##########'),
            'phone_number' => fake()->e164PhoneNumber(),
        ];
    }
}
