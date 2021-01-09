<?php

namespace App\Http\Controllers\Web;

use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CartAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->guard('customer')->check()){
            return redirect()->home();
        }

        return view('web/login');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        auth()->guard('customer')->logout();
		session()->flush();
        $request->session()->forget('customer_id');
		$request->session()->regenerate();
        
        return redirect(route('auth.login'));
    }

    public function processLogin()
    {
        $sessionID = Session::getId();

        $loginData = request()->validate([
            'email' => ['required', 'string', 'email', 'max:150'],
            'password' => ['required'],
        ]);

        $loginData['is_verified'] = 1;

		if (!auth()->guard('customer')->attempt($loginData)) {
			return back()->withErrors([
				'message' => 'Please check your credentials and try again.'
			])->withInput();
        }

        session(['customer_id' => currentCustomer()->id]);

        /* 
            Cart Logic
            Check if session customers_id is empty
                if empty = get cart data using sessionID
                else = get cart data using session customer_id
        */

        $cart = Cart::where('session_id',$sessionID)->get();

        if (count($cart)) {
            foreach ($cart as $cartData) {
                Cart::where([
                    ['customer_id', '=', currentCustomer()->id],
                    ['product_id', '=', $cartData->product_id],
                    ['is_order', '=', '0']
                ])->delete();
            }
        }

        Cart::where('session_id',$sessionID)
            ->update([
                'customer_id' => currentCustomer()->id
            ]);
        
        CartAttribute::where('session_id',$sessionID)
            ->update([
                'customer_id' => currentCustomer()->id
            ]);

        return redirect()->home();
    }
    
}