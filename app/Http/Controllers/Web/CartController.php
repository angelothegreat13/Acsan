<?php

namespace App\Http\Controllers\Web;


use App\Models\Cart;
use App\Models\Product;
use App\Models\CartAttribute;
use App\Models\ProductOption;
use App\Models\ProductAttribute;
use App\Models\ProductOptionValue;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::select('carts.*','products.image AS product_img','products.slug AS product_slug','products.name AS product')
            ->leftJoin('products','carts.product_id','=','products.id')->where('is_order',0);

        if (empty(session('customer_id'))) {
            $cartData = $carts->where('session_id',Session::getId())->get();
        } 
        else {
            $cartData = $carts->where('customer_id',session('customer_id'))->get();
        }
        
        $data = [];

        foreach ($cartData as $key => $cart) 
        {
            $data[$key]['cart'] = $cart;

            $cartID = $cart->id;
            $productID = $cart->product_id;

            $cartAttributes = CartAttribute::where('cart_id',$cartID)
                ->where('product_id',$productID);

            if (empty(session('customer_id'))) {
                $cartAttribs = $cartAttributes->where('session_id',Session::getId())->get();
            }
            else {
                $cartAttribs = $cartAttributes->where('customer_id',session('customer_id'))->get();
            }

            $data[$key]['cart_attributes'] = $cartAttribs;
        }
        
        return view('web/cart',[
            'data' => $data,
            'cartTotal' => Cart::total()
        ]);
    }

    protected static function saveCartAttribute()
    {
        CartAttribute::create([
            'cart_id' => $latestCartID,
            'product_id' => $productID,
            'product_option_id' => 1,
            'product_option_value_id' => $optionValueID,
            'session_id' => $sessionID
        ]);
    }

    protected static function getAttribData($productID,$optionID,$optionValueID)
    {
        return ProductAttribute::from('product_attributes AS pa')
            ->select('pa.*','po.name AS product_option','pov.name AS product_option_value')
            ->join('product_options AS po','pa.product_option_id','=','po.id')
            ->join('product_option_values AS pov','pa.product_option_value_id','=','pov.id')
            ->where('pa.product_id',$productID)
            ->where('pa.product_option_id',$optionID)
            ->where('pa.product_option_value_id',$optionValueID)
            ->first();
    }

    // !This need a fix and refactor
    // TODO: add upload logo
    public function store()
    {
        $sessionID = Session::getId();
        $productID = request()->product_id;
        $customerID = session('customer_id');

        $productData = Product::where('id',$productID)->first();
        $productOptions = ProductOption::all();

        $optionsArr = [];
        $optionValuesID = [];
        
        foreach ($productOptions as $i => $productOption) 
        {
            $optionValueID = request()->{$productOption->name};

            if (isset($optionValueID)) {
                $optionsArr[$i]['option_id'] = $productOption->id;
                $optionsArr[$i]['option_value_id'] = $optionValueID;
                $optionValuesID[] = $productOption->id.$optionValueID;
            }
        }
        
        $optionValuesID = implode("", $optionValuesID);

        if (empty($customerID)) {
            $cartData = Cart::where([
                ['session_id', '=', $sessionID],
                ['product_id', '=', $productID],
                ['is_order', '=', 0],
                ['option_values_id', '=', $optionValuesID]
            ])->get();
        }
        else 
        {
            $cartData = Cart::where([
                ['customer_id', '=', $customerID],
                ['product_id', '=', $productID],
                ['is_order', '=', 0],
                ['option_values_id', '=', $optionValuesID]
            ])->get();
        }
        
        // check if cart is empty or not
        if (count($cartData) === 0) 
        {
            $cart = new Cart;
            $cart->customer_id = $customerID;
            $cart->product_id = $productID;
            $cart->product_name = $productData->name;
            $cart->session_id = $sessionID;
            $cart->price = $productData->price;
            $cart->quantity = request()->qty;
            $cart->final_price = $productData->price * request()->qty;
            $cart->option_values_id = $optionValuesID;
            $cart->save();

            $latestCartID = $cart->id;
            $attribTotal = 0;

            if (count($optionsArr)) 
            {
                foreach ($optionsArr as $opt) 
                {
                    $prodAttrib = self::getAttribData($productID,$opt['option_id'],$opt['option_value_id']);

                    CartAttribute::create([
                        'cart_id' => $latestCartID,
                        'customer_id' => $customerID,
                        'product_id' => $productID,
                        'product_option_id' => $opt['option_id'],
                        'product_option_value_id' => $opt['option_value_id'],
                        'session_id' => $sessionID,
                        'product_option_name' => $prodAttrib->product_option,
                        'product_option_value_name' => $prodAttrib->product_option_value,
                        'product_option_value_price' => $prodAttrib->product_option_value_price
                    ]);

                    $prodAttribPrice = $prodAttrib->product_option_value_price;
                    $attribTotal+= $prodAttribPrice;
                }
            }

            if ($attribTotal != 0) {
                $finalProdPrice = $productData->price * request()->qty;
                $finalAttribPrice = $attribTotal * request()->qty;
                $finalPrice = $finalProdPrice + $finalAttribPrice;

                Cart::where('id',$latestCartID)->update(['final_price' => $finalPrice]);
            }
        }
        else 
        {
            $newQty = $cartData->first()->quantity + request()->qty;
            $cartID = $cartData->first()->id;

            // check if there is product attrib
            if (count($optionsArr)) 
            {
                $cartAttribExist = true;
                
                foreach ($optionsArr as $opt) 
                {
                    $cartAttribData = CartAttribute::where([
                        ['cart_id', $cartID],
                        ['customer_id', $customerID],
                        ['product_id', $productID],
                        ['product_option_id', $opt['option_id']],
                        ['product_option_value_id', $opt['option_value_id']]
                    ])->get();

                    if (count($cartAttribData) === 0) {
                        $cartAttribExist = false;
                        break;
                    }
                }

                // if cart attrib exists update the cart data
                if ($cartAttribExist) 
                {
                    $baseFinalPrice = $cartData->first()->final_price / $cartData->first()->quantity;

                    Cart::where('id',$cartID)
                        ->update([
                            'quantity' => $newQty,
                            'final_price' => $baseFinalPrice * $newQty
                        ]);
                }
                else  // Add new product in cart and cart attribute
                { 
                    $cart = new Cart;
                    $cart->customer_id = $customerID;
                    $cart->product_id = $productID;
                    $cart->product_name = $productData->name;
                    $cart->session_id = $sessionID;
                    $cart->price = $productData->price;
                    $cart->quantity = request()->qty;
                    $cart->final_price = $productData->price * request()->qty;
                    $cart->option_values_id = $optionValuesID;
                    $cart->save();

                    $latestCartID = $cart->id;
                    $attribTotal = 0;

                    foreach ($optionsArr as $opt) 
                    {
                        $prodAttrib = self::getAttribData($productID,$opt['option_id'],$opt['option_value_id']);

                        CartAttribute::create([
                            'cart_id' => $latestCartID,
                            'customer_id' => $customerID,
                            'product_id' => $productID,
                            'product_option_id' => $opt['option_id'],
                            'product_option_value_id' => $opt['option_value_id'],
                            'session_id' => $sessionID,
                            'product_option_name' => $prodAttrib->product_option,
                            'product_option_value_name' => $prodAttrib->product_option_value,
                            'product_option_value_price' => $prodAttrib->product_option_value_price
                        ]);

                        $prodAttribPrice = $prodAttrib->product_option_value_price;
                        $attribTotal+= $prodAttribPrice;
                    }

                    if ($attribTotal != 0) {
                        $finalProdPrice = $productData->price * request()->qty;
                        $finalAttribPrice = $attribTotal * request()->qty;
                        $finalPrice = $finalProdPrice + $finalAttribPrice;

                        Cart::where('id',$latestCartID)->update(['final_price' => $finalPrice]);
                    }
                }
            }
            else {
                Cart::where('id',$cartID) // update cart table data if no attributes
                    ->update([
                        'price' => $productData->price,
                        'quantity' => $newQty,
                        'final_price' => $productData->price * $newQty
                    ]);
            }
        }

        return redirect()->back()->with('success', 'Product successfully added to your cart!');
    }
    
    // TODO: Delete also the cart attribute
    public function destroy($cartID)
    {
        Cart::where('id',$cartID)->delete();
        CartAttribute::where('cart_id',$cartID)->delete();

        return redirect()->back()->with('success', 'Cart row sucessfully deleted');
    }
}