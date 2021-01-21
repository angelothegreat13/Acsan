<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TotalSalesReportController extends Controller
{
    public function filter()
    {
        $orders = '';

        switch (request()->type) 
        {
            case 'daily':
                $orders = Order::select(DB::raw('DATE(created_at) AS date,SUM(CASE WHEN status = 6 THEN (total * 0.70) ELSE total END) AS sale'))
                    ->where('status', '<>', 2)
                    ->whereRaw('DATE(created_at) = CURDATE()')
                    ->groupBy('date')
                    ->get();
            break;

            case 'weekly':
                $orders = Order::select(DB::raw('DAYNAME(created_at) AS date,SUM(CASE WHEN status = 6 THEN (total * 0.70) ELSE total END) AS sale'))
                    ->where('status', '<>', 2)
                    ->whereRaw('WEEKOFYEAR(created_at) = WEEKOFYEAR(NOW())')
                    ->groupBy(DB::raw('DAY(created_at),DAYNAME(created_at)'))
                    ->orderByRaw('DAY(created_at)')
                    ->get();
            break;

            case 'monthly':
                $orders = Order::select(DB::raw('MONTHNAME(created_at) AS date,SUM(CASE WHEN status = 6 THEN (total * 0.70) ELSE total END) AS sale'))
                    ->where('status', '<>', 2)
                    ->whereRaw('YEAR(created_at) = YEAR(NOW())')
                    ->groupBy(DB::raw('MONTH(created_at),date'))
                    ->get();                    
            break;

            case 'yearly':
                $orders = Order::select(DB::raw('YEAR(created_at) AS date,SUM(CASE WHEN status = 6 THEN (total * 0.70) ELSE total END) AS sale'))
                    ->where('status', '<>', 2)
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
            break;
        }

        return response()->json($orders);
    }


}