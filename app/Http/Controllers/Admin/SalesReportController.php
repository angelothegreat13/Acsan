<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SalesReportController extends Controller
{    
    public static function paidOrders()
    {
        return Order::with('customer')->where('status', '<>', 2)->latest()->get();
    }

    public function index()
    {   
        return view('admin/reports/sales-report',[
            'sales' => self::paidOrders(),
            'totalSales' => Order::where('status', '<>', 2)->sum('total')
        ]);
    }

    public function filter()
    {
        $orders = '';

        switch (request()->type) 
        {
            case 'daily':
                $orders = Order::with('customer')->dailySalesReport()->get();
            break;

            case 'weekly':
                $orders = Order::with('customer')->weeklySalesReport()->get();
            break;

            case 'monthly':
                $orders = Order::with('customer')->monthlySalesReport()->get();
            break;

            case 'yearly':
                $orders = Order::with('customer')->yearlySalesReport()->get();
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
                $sales = Order::with('customer')->dailySalesReport()->get();
            break;

            case 'weekly':
                $sales = Order::with('customer')->weeklySalesReport()->get();
            break;

            case 'monthly':
                $sales = Order::with('customer')->monthlySalesReport()->get();
            break;

            case 'yearly':
                $sales = Order::with('customer')->yearlySalesReport()->get();
            break;
        }

        $spreadsheet = new Spreadsheet();
		
		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();
		
        $activeSheet->setCellValue('A1', 'ORDER ID');
		$activeSheet->setCellValue('B1', 'CUSTOMER');
		$activeSheet->setCellValue('C1', 'TOTAL SALE');
        $activeSheet->setCellValue('D1', 'ORDERED DATE');
        
        $row = 2;
        foreach ($sales as $sale) 
        {
			$activeSheet->setCellValue('A'.$row , $sale->id);
			$activeSheet->setCellValue('B'.$row , ucwords($sale->customer->firstname.' '.$sale->customer->lastname));
            $activeSheet->setCellValue('C'.$row , '₱ '.number_format((float)$sale->total, 2, '.', ''));
            $activeSheet->setCellValue('D'.$row , $sale->created_at->format('m-d-Y H:i'));
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