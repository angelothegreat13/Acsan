<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('web.home',[
            'products' => Product::with('category')->get()
        ]);
    }
}