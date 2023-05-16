<?php

use Illuminate\Support\Facades\Route;
use Src\Customer\Presentation\API\V1\Controllers\CreateCustomerController;
use Src\Customer\Presentation\API\V1\Controllers\CustomersController;
use Src\Customer\Presentation\API\V1\Controllers\DeleteCustomerController;
use Src\Customer\Presentation\API\V1\Controllers\GetCustomerByIdController;
use Src\Customer\Presentation\API\V1\Controllers\UpdateCustomerController;

Route::prefix('api/v1/customer')->group(function () {
    Route::get('/', CustomersController::class)->name('getCustomers');
    Route::get('/{id}', GetCustomerByIdController::class)->name('getCustomer');
    Route::post('/', CreateCustomerController::class)->name('createCustomer');
    Route::put('/{id}', UpdateCustomerController::class)->name('updateCustomer');
    Route::delete('/{id}', DeleteCustomerController::class)->name('deleteCustomer');
});
