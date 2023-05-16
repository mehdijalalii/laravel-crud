<?php

namespace Src\Customer\Presentation\API\V1\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Customer\Application\Rules\BankAccountNumberRule;
use Src\Customer\Application\Rules\UniqueCustomer;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $method = $this->getMethod();

        if ($method === 'POST') {
            return $this->getPostValidationRules();
        } elseif ($method === 'PUT') {
            return $this->getPutValidationRules();
        }

        return [];
    }

    /**
     * Get the common validation rules for both POST and PUT methods.
     *
     * @return array
     */
    private function getCommonValidationRules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'bank_account_number' => ['required', new BankAccountNumberRule],
            'phone_number' => ['required', 'phone'],
            'date_of_birth' => ['required','date', new UniqueCustomer],
        ];
    }

    /**
     * Get the validation rules for POST method.
     *
     * @return array
     */
    private function getPostValidationRules(): array
    {
        $validationRules = $this->getCommonValidationRules();
        $validationRules['email'] = 'required|email|unique:customers';

        return $validationRules;
    }

    /**
     * Get the validation rules for PUT method.
     *
     * @return array
     */
    private function getPutValidationRules(): array
    {
        $validationRules = $this->getCommonValidationRules();
        $validationRules['email'] = 'required|email|unique:customers,email,' . $this->id;
        $validationRules['date_of_birth'] = ['required','date', new UniqueCustomer($this->id)];

        return $validationRules;
    }

    protected function passedValidation()
    {
        $preparedData = $this->prepareData($this->validated());

        $this->replace($preparedData);
    }


    private function prepareData(array $validatedData): array
    {
        $validatedData['phone_number'] = removeNonDigitCharacters($validatedData['phone_number']);

        return $validatedData;
    }

    public function messages()
    {
        return [
            'date_of_birth.unique' => 'شما قبلا ثبت نام کرده‌اید'
        ];
    }
}
