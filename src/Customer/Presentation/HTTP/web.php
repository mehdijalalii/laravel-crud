<?php

use Illuminate\Support\Facades\Route;
use Src\Customer\Presentation\HTTP\Controllers\CustomerController;

Route::get('/', [CustomerController::class, 'index']);
