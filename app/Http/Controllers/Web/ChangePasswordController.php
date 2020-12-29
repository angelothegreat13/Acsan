<?php

namespace App\Http\Controllers\Web;

use App\Models\Customer;
use App\Rules\MatchOldPassword;
use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('web.change-password');
    }

    public function update(Customer $customer)
    {
        $validated = request()->validate([
            'current_password' => ['required','min:6',new MatchOldPassword($customer->password)],
            'new_password' => 'required|min:6',
            'new_confirm_password' => 'required|same:new_password|min:6'
        ]);

        $customer->password = bcrypt($validated['new_password']);
        $customer->save();
        
        return back()->with('success', 'Password sucessfully updated');
    }
    
}