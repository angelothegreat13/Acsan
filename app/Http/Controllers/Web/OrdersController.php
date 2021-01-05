<?php

namespace App\Http\Controllers\Web;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\CartAttribute;
use App\Http\Controllers\Controller;
use App\Models\OrderProductAttribute;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id',currentCustomer()->id)
            ->with('orderStatus')
            ->orderBy('created_at','DESC')
            ->get();

        return view('web.orders.index',compact('orders'));
    }

    public function manage($orderID)
    {
        $order = Order::where('id',$orderID)->with('orderStatus')->first();

        $orderProducts = OrderProduct::select('order_products.*','products.image AS prod_img')
            ->where('order_id',$orderID)
            ->join('products','order_products.product_id','=','products.id')
            ->get();

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

        return view('web.orders.manage',[
            'order' => $order,
            'customer' => $order->customer,
            'data' => $data
        ]);
    }

    public function checkout()
    {
        if (empty(session('customer_id'))) {
            return redirect('auth.login');
        }

        $carts = Cart::select('carts.*','products.image AS product_img','products.slug AS product_slug','products.name AS product')
            ->leftJoin('products','carts.product_id','=','products.id')
            ->where('is_order',0)
            ->where('customer_id',session('customer_id'))
            ->get();
        
        $data = [];

        foreach ($carts as $key => $cart) 
        {
            $data[$key]['cart'] = $cart;

            $cartID = $cart->id;
            $productID = $cart->product_id;

            $cartAttribs = CartAttribute::where('cart_id',$cartID)
                ->where('product_id',$productID)
                ->where('customer_id',session('customer_id'))
                ->get();

            $data[$key]['cart_attributes'] = $cartAttribs;
        }

        return view('web/checkout',[
            'data' => $data,
            'cartSubTotal' => Cart::total(),
            'cartTotal' => Cart::total()
        ]);
    }

    public function processCheckout()
    {
        $customerID = currentCustomer()->id;

        // insert data to orders table
        $order = new Order;
        $order->customer_id = currentCustomer()->id;
        $order->status = 2; // new
        $order->sub_total = Cart::total();
        $order->total = Cart::total();
        $order->save();

        $orderID = $order->id;

        // Get Cart data 
        $carts = Cart::where('customer_id',$customerID)
            ->where('is_order',0)
            ->get();

        foreach ($carts as $cart) 
        {
            // insert to order products
            $orderProduct = new OrderProduct;        
            $orderProduct->order_id = $orderID;
            $orderProduct->product_id = $cart->product_id;
            $orderProduct->product_name = $cart->product_name;
            $orderProduct->product_price = $cart->price;
            $orderProduct->product_qty = $cart->quantity;
            $orderProduct->product_final_price = $cart->final_price;
            $orderProduct->logo = $cart->logo;
            $orderProduct->save();

            $orderProductID = $orderProduct->id;
            
            // get cart attribute using cartID, customerID, productID
            $cartAttributes = CartAttribute::where('cart_id',$cart->id)
                ->where('customer_id',$customerID)
                ->where('product_id',$cart->product_id)
                ->get();
                
            // check if product has attribute then inser to order product attributes
            if (count($cartAttributes)) 
            {
                foreach ($cartAttributes as $cartAttrib) {
                    $orderProductAttribute = new OrderProductAttribute;
                    $orderProductAttribute->order_id = $orderID;
                    $orderProductAttribute->order_product_id = $orderProductID;
                    $orderProductAttribute->product_id = $cartAttrib->product_id;
                    $orderProductAttribute->product_option = $cartAttrib->product_option_name;
                    $orderProductAttribute->product_option_value = $cartAttrib->product_option_value_name;
                    $orderProductAttribute->product_option_value_price = $cartAttrib->product_option_value_price;
                    $orderProductAttribute->price_prefix = '+';
                    $orderProductAttribute->save();
                }
            }
        }

        Cart::where('customer_id',$customerID)->where('is_order',0)->update(['is_order' => 1]);
 
        return view('web/thank-you')->with('orderID', $orderID);
    }

    public function uploadBankStatement(Request $request,Order $order)
    {
        $validated = $request->validate([
            'bank_statement' => ['required']
        ]);

        if ($request->hasFile('bank_statement')) {
            $imgName = time().'.'.$request->bank_statement->extension();
            $request->bank_statement->move('img/bank', $imgName);
            $imgURL = 'img/bank/'.$imgName;

            $order->bank_statement = $imgURL; 
        }

        $order->save();

        return redirect()->back()->with('success', 'Bank statement has been successfully uploaded');
    }
}