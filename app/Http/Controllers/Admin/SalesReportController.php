<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SalesReportController extends Controller
{    
    public static function paidOrders()
    {
        return Order::with('customer','orderStatus')
            ->where('status', '<>', 2)
            ->orderBy('id','DESC')
            ->get();
    }

    public function index()
    {   
        $totalSales = Order::select(DB::raw('SUM(CASE WHEN status = 6 THEN (total * 0.70) ELSE total END) AS total'))
            ->where('status', '<>', 2)
            ->first()->total;
        return view('admin/reports/sales-report',[
            'sales' => self::paidOrders(),
            'totalSales' => $totalSales
        ]);
    }

    public function filter()
    {
        $orders = '';

        switch (request()->type) 
        {
            case 'daily':
                $orders = Order::with('customer','orderStatus')->dailySalesReport()->get();
            break;

            case 'weekly':
                $orders = Order::with('customer','orderStatus')->weeklySalesReport()->get();
            break;

            case 'monthly':
                $orders = Order::with('customer','orderStatus')->monthlySalesReport()->get();
            break;

            case 'yearly':
                $orders = Order::with('customer','orderStatus')->yearlySalesReport()->get();
            break;
        }

        return response()->json($orders);
    }

    public function exportExcel()
    {
        $filter = request()->filter;
        $sales = self::paidOrders();

        switch ($filter) 
        {
            case 'daily':
                $sales = Order::with('customer','orderStatus')->dailySalesReport()->get();
            break;

            case 'weekly':
                $sales = Order::with('customer','orderStatus')->weeklySalesReport()->get();
            break;

            case 'monthly':
                $sales = Order::with('customer','orderStatus')->monthlySalesReport()->get();
            break;

            case 'yearly':
                $sales = Order::with('customer','orderStatus')->yearlySalesReport()->get();
            break;
        }

        $spreadsheet = new Spreadsheet();
		
		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();
		
        $activeSheet->setCellValue('A1', 'ORDER ID');
        $activeSheet->setCellValue('B1', 'CUSTOMER');
		$activeSheet->setCellValue('C1', 'STATUS');
		$activeSheet->setCellValue('D1', 'TOTAL SALE');
        $activeSheet->setCellValue('E1', 'ORDERED DATE');
        
        $row = 2;
        foreach ($sales as $sale) 
        {
            $totalSale = ($sale->status === 6) ? $sale->total * 0.70 : $sale->total;

			$activeSheet->setCellValue('A'.$row , $sale->id);
            $activeSheet->setCellValue('B'.$row , ucwords($sale->customer->firstname.' '.$sale->customer->lastname));
            $activeSheet->setCellValue('C'.$row , $sale->orderStatus->name);
            $activeSheet->setCellValue('D'.$row , '₱ '.number_format((float)$totalSale, 2, '.', ''));
            $activeSheet->setCellValue('E'.$row , $sale->created_at->format('m-d-Y H:i'));
            $row++;
		}

        $filename = 'sales-report-'.now().'.xlsx';
        $excelWriter = new Xlsx($spreadsheet);
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename='. $filename);
        header('Cache-Control: max-age=0');
        
        return $excelWriter->save('php://output');
    }

}