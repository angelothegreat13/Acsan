<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesReportController extends Controller
{
    public function index()
    {
        $sales = Order::with('customer')->get();

        return view('admin/reports/sales-report',compact('sales'));
    }


}