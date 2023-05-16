<?php

namespace Src\Customer\Application\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Src\Customer\Infrastructure\Elequent\Models\Customer;

class UniqueCustomer implements Rule
{
    protected $ignoreId;

    public function __construct($ignoreId = null)
    {
        $this->ignoreId = $ignoreId;
    }

    public function passes($attribute, $value)
    {
        [$firstName, $lastName, $dateOfBirth] = $this->getRequestValues();

        $query = Customer::query()
            ->where('first_name', $firstName)
            ->where('last_name', $lastName)
            ->where('date_of_birth', $dateOfBirth);

            if (!is_null($this->ignoreId)) {
                $query->where('id', '<>', $this->ignoreId);
            }

        $count = $query->count();

        return $count === 0;
    }

    protected function getRequestValues(): array
    {
        $request = request();

        return [
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('date_of_birth'),
        ];
    }

    public function message(): string
    {
        return 'کاربر از قبل وجود دارد';
    }
}
