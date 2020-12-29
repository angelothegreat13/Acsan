<?php

namespace App\Http\Controllers\Web;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $customer = Customer::find(currentCustomer()->id)->first();

        return view('web/profile',compact('customer'));
    }

    public function update(Customer $customer)
    {
        $validated = request()->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required','min:2','unique:customers,email,'.$customer->id],
            'contact_number' => ['required'],
            'address' => ['required','min:2'],
        ]);
        
        $customer->update($validated);
        
        return redirect()->back()->with('success', 'Profile has been successfully updated');
    }

}