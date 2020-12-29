<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard',[
            'newOrders' => Order::where('status',2)->count(),
            'totalProducts' => Product::all()->count(),
            'totalCustomers' => Customer::all()->count(),
            'totalCategories' => Category::all()->count()
        ]);
    }

}