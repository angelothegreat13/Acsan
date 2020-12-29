<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->guard('admin')->check()){
            return redirect(route('admin.dashboard'));
        }
        
        return view('admin.login');
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        
        return redirect(route('admin.auth.login'));
    }

    public function processLogin()
    {
        $loginData = request()->validate([
            'email' => ['required', 'string', 'email', 'max:150'],
            'password' => ['required'],
        ]);

		if (!auth()->guard('admin')->attempt($loginData)) {
			return back()->withErrors('Please check your credentials and try again.')->withInput();
        }
        
        return redirect(route('admin.dashboard'));
    }
    
}