<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug',$slug)->first();

        $options = ProductAttribute::from('product_attributes AS pra')
            ->select('pra.product_option_id','pro.name','pro.label','pro.type')
            ->join('product_options AS pro','pra.product_option_id','=','pro.id')
            ->where('pra.product_id',$product->id)
            ->groupBy('product_option_id')
            ->get();
        
        $productAttributes = [];

        foreach ($options as $key => $option) 
        {
            $productAttributes[$key]['option']['option_id'] = $option->product_option_id;
            $productAttributes[$key]['option']['label'] = $option->label;
            $productAttributes[$key]['option']['name'] = $option->name;
            $productAttributes[$key]['option']['type'] = $option->type;

            $attribs = ProductAttribute::from('product_attributes AS pra')
                ->select('pra.*','prov.name AS product_option_value')
                ->join('product_option_values AS prov','pra.product_option_value_id','=','prov.id')
                ->where('pra.product_id',$product->id)
                ->where('pra.product_option_id',$option->product_option_id)
                ->get();

            foreach ($attribs as $attrib) {
                $productAttributes[$key]['values'][] = [
                    'product_attribute_id' => $attrib->id,
                    'option_value_id' => $attrib->product_option_value_id,
                    'value' => $attrib->product_option_value,
                    'price' => $attrib->product_option_value_price,
                    'price_prefix' => $attrib->price_prefix,
                    'is_default' => $attrib->is_default,
                    'color_img' => $attrib->color_img,
                ];
            }
        }

        // return [
        //     'product' => $product,
        //     'productAttributes' => $productAttributes
        // ];
        
        return view('web/product-details',[
            'product' => $product,
            'productAttributes' => $productAttributes
        ]);
    }

}