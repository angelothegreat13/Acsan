<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    public function index($category)
    {
        $categoryData = Category::where('slug',$category)->first();

        return view('web/shop',[
            'products' => Product::where('category_id',$categoryData->id)->get(),
            'categoryName' => $categoryData->name
        ]);
    }
}