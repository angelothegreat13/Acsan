<?php

namespace App\Http\Controllers\Web;

use App\Models\Customer;
use App\Mail\EmailVerify;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;


class RegistrationController extends Controller
{
    public function index()
    {
        if (auth()->guard('customer')->check()){
            return redirect()->home();
        }

        return view('web/register');
    }

    public function process()
    {
        $validatedData = request()->validate([
            'firstname' => ['required','min:2','max:100'],
            'lastname' => ['required','min:2','max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'contact_number' => ['required'],
            'address' => ['required','min:2'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $validatedData['password'] = bcrypt(request(('password')));
        $validatedData['verification_code'] = sha1(time());

        Customer::create($validatedData);

        Mail::to($validatedData['email'])->send(
            new EmailVerify($validatedData['firstname'],$validatedData['verification_code'])
        );

        return redirect(route('auth.login'))->with('success', 'Your Account has been created. Please check your email for verification link.');
    }

    public function verifyCustomer($code)
    {
        $customer = Customer::where('verification_code',$code)->first();

        if ($customer) {
            $customer->email_verified_at = now();
            $customer->is_verified = 1;
            $customer->save();
            
            return redirect(route('auth.login'))->with('success', 'Your account is verified. Please login!');
        }

        return back()->withErrors(['message' => 'Invalid verification code!']);
    }

}