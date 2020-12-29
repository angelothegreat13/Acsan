<?php

namespace App\Http\Controllers\Web;

use App\Models\Customer;
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

        Customer::create($validatedData);

        return redirect(route('auth.login'))->with('success', 'Your Account has been Successfully Registered');
    }

}