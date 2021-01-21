<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderProduct;
use App\Models\OrderProductAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer','orderStatus')->get();

        return view('admin.orders.index',compact('orders'));
    }

    public function manage(Order $order)
    {
        $orderID = $order->id;

        $orderProducts = OrderProduct::select('order_products.*','products.image AS prod_img')
            ->where('order_id',$orderID)
            ->join('products','order_products.product_id','=','products.id')
            ->get();

        $totalQty = OrderProduct::where('order_id',$orderID)->sum('product_qty');
            
        $data = [];

        foreach ($orderProducts as $key => $orderProduct) 
        {
            $data[$key]['order_products'] = $orderProduct;

            // orderid, order_product_id, product_id
            $orderProductID = $orderProduct->id;
            $productID = $orderProduct->product_id;

            $order_product_attribs = OrderProductAttribute::where('order_id',$orderID)
                ->where('order_product_id',$orderProductID)
                ->where('product_id',$productID)
                ->get();

            $data[$key]['order_product_attribs'] = $order_product_attribs;
        }

        return view('admin.orders.manage',[
            'order' => $order,
            'customer' => $order->customer,
            'data' => $data,
            'totalQty' => $totalQty,
            'orderStatus' => OrderStatus::all()
        ]);
    }

    public function updateOrderStatus(Order $order)
    {
        $order->status = request()->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status has been successfully updated');
    }

    public function uploadDeliveryReceipt(Request $request,Order $order)
    {
        $validated = $request->validate([
            'delivery_receipt' => ['required']
        ]);

        if ($request->hasFile('delivery_receipt')) {
            $imgName = time().'.'.$request->delivery_receipt->extension();
            $request->delivery_receipt->move('img/delivery-receipts', $imgName);
            $imgURL = 'img/delivery-receipts/'.$imgName;

            $order->delivery_receipt = $imgURL; 
        }

        $order->save();

        return redirect()->back()->with('successDelivery', 'Delivery Receipt has been successfully uploaded');
    }

}