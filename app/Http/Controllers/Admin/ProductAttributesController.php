<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\ProductOptionValue;
use App\Http\Controllers\Controller;

class ProductAttributesController extends Controller
{
    public function getOptionValues()
    {
        $optionID = request()->optionID;

        if ($optionID !== NULL) {
            return ProductOptionValue::where('product_option_id',$optionID)->get()->toJson();
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'option_name' => ['required'],
            'option_value' => ['required'],
            'price' => ['required']
        ]);

        $prodID = $request->product_id;

        $attribData = ProductAttribute::where('product_id',$prodID)
            ->where('product_option_id',$validated['option_name'])
            ->where('product_option_value_id',$validated['option_value'])
            ->get();

        if (count($attribData)) {
            return back()->withErrors(['message' => 'Option and option value already added.']);
        }

        $productAttrib = new ProductAttribute;

        if ($request->hasFile('color_img')) {
            $imgName = time().'.'.$request->color_img->extension();
            $request->color_img->move('img/product', $imgName);
            $imgURL = 'img/product/'.$imgName;

            $productAttrib->color_img = $imgURL; //save image url to database
        }

        $productAttrib->product_id = $prodID;
        $productAttrib->product_option_id = $validated['option_name'];
        $productAttrib->product_option_value_id = $validated['option_value'];
        $productAttrib->product_option_value_price = $validated['price'];
        $productAttrib->price_prefix = '+';
        $productAttrib->save();

        return redirect()->back()->with('success', 'Product Attribute sucessfully added');
    }

    public function destroy(ProductAttribute $productAttrib)
    {
        $productAttrib->delete();

        return redirect()->back()->with('success', 'Product Attribute sucessfully deleted');
    }
    
    public function edit()
    {

    }

    public function update()
    {

    }
}