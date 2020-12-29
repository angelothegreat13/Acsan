<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return view('admin.customers.index',compact('customers'));
    }

}