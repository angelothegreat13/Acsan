<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SalesReportController extends Controller
{
    public function index()
    {   
        return view('admin/reports/sales-report',[
            'sales' => Order::with('customer')->where('status',4)->get(),
            'totalSales' => Order::where('status',4)->sum('total')
        ]);
    }

}