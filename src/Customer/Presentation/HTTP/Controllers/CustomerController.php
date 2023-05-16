<?php

namespace Src\Customer\Presentation\HTTP\Controllers;

use App\Http\Controllers\Controller;
use Src\Customer\Infrastructure\Elequent\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();

        return view('index', compact('customers'));
    }
}
