<?php

namespace Src\Customer\Infrastructure\Elequent\Repositories;

use Src\Customer\Domain\Customer;
use Src\Customer\Domain\CustomerId;
use Src\Customer\Domain\Customers;
use Src\Customer\Domain\CustomerRepositoryInterface;
use Src\Shared\Infrastructure\Eloquent\EloquentCriteriaTransformer;
use Src\Shared\Infrastructure\Eloquent\EloquentException;
use Exception;
use Illuminate\Support\Facades\DB;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Customer\Infrastructure\Elequent\Models\Customer as CustomerModel;

final class CustomerRepository implements CustomerRepositoryInterface
{
    private CustomerModel $model;

    public function __construct(CustomerModel $model)
    {
        $this->model = $model;
    }

    public function delete(CustomerId $id): void
    {
        $customer = $this->model->find($id->value);

        $customer->delete();
    }

    public function findBy(Criteria $criteria): Customers
    {
        $eloquentCustomer = (new EloquentCriteriaTransformer($criteria, $this->model))
            ->builder()
            ->first()
        ;

        $eloquentCustomers = $this->model->all();

        $customers = $eloquentCustomers->map(
            function (CustomerModel $eloquentCustomer) {
                return $this->toDomain($eloquentCustomer);
            }
        )->toArray();

        return new Customers($customers);
    }

    public function findOneBy(Criteria $criteria): ?Customer
    {
        /** @var CustomerModel $eloquentCustomer */
        $eloquentCustomer = (new EloquentCriteriaTransformer($criteria, $this->model))
            ->builder()
            ->first();

        if (null === $eloquentCustomer) {
            return null;
        }

        return $this->toDomain($eloquentCustomer);
    }

    private function toDomain(CustomerModel $eloquentCustomerModel): Customer
    {
        return Customer::fromPrimitives(
            $eloquentCustomerModel->id,
            $eloquentCustomerModel->first_name,
            $eloquentCustomerModel->last_name,
            $eloquentCustomerModel->date_of_birth,
            $eloquentCustomerModel->phone_number,
            $eloquentCustomerModel->email,
            $eloquentCustomerModel->bank_account_number
        );
    }

    /**
     * @throws EloquentException
     */
    public function save(Customer $customer): void
    {
        $customerModel = $this->model->find($customer->id->value);

        if (null === $customerModel) {
            $customerModel = new CustomerModel;
            $customerModel->id = $customer->id->value;
        }

        $customerModel->first_name = $customer->firstName->value;
        $customerModel->last_name = $customer->lastName->value;
        $customerModel->date_of_birth = $customer->dateOfBirth->value;
        $customerModel->phone_number = $customer->phoneNumber->value;
        $customerModel->email = $customer->email->value;
        $customerModel->bank_account_number = $customer->bankAccountNumber->value;

        DB::beginTransaction();
        try {
            $customerModel->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new EloquentException(
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            );
        }
    }

}
