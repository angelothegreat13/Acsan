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
        return Order::with('customer')->where('status',4)->get();
    }

    public function index()
    {   
        return view('admin/reports/sales-report',[
            'sales' => self::paidOrders(),
            'totalSales' => Order::where('status',4)->sum('total')
        ]);
    }

    public function exportExcel()
    {
        $sales = self::paidOrders();

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