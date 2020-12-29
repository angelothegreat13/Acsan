<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductOption;
use App\Models\ProductAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index()
    {           
        return view('admin.products.index',[
            'products' => Product::with('category')->get()
        ]);
    }

    public function create()
    {
        return view('admin.products.create',[
            'categories' => Category::all(),
            'options' => ProductOption::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','min:2','unique:products,name'],
            'category' => ['required'],
            'price' => ['required','numeric'],
            'description' => ['required','min:10'],
            'image' => ['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ]);

        $imgName = time().'.'.$request->image->extension();
        $request->image->move('img/product', $imgName);
        $imgURL = 'img/product/'.$imgName;

        Product::create([
            'category_id' => $validated['category'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image' => $imgURL
        ]);

        return redirect(route('admin.products.index'))->with('success', 'New Product has been successfully added');
    }

    public function edit($id)
    {
        return view('admin.products.edit',[
            'product' => Product::where('id',$id)->first(),
            'categories' => Category::all(),
            'options' => ProductOption::all()
        ]);
    }

    public function update(Request $request,Product $product)
    {
        $validated = $request->validate([
            'name' => ['required','min:2','unique:products,name,'.$product->id],
            'category' => ['required'],
            'price' => ['required','numeric'],
            'description' => ['required','min:10']
        ]);

        $product->name = $validated['name'];
        $product->slug = Str::slug($validated['name']);
        $product->category_id = $validated['category'];
        $product->price = $validated['price'];
        $product->description = $validated['description'];

        if ($request->hasFile('image')) {
            $imgName = time().'.'.$request->image->extension();
            $request->image->move('img/product', $imgName);
            $imgURL = 'img/product/'.$imgName;

            $product->image = $imgURL; //save image url to database
        }

        $product->save();

        return redirect(route('admin.products.index'))->with('success', 'Product has been successfully updated');
    }

    public function attribute($productID)
    {
        $attributes = ProductAttribute::from('product_attributes AS pa')
            ->select(
                'pa.id AS product_attrib_id',
                'po.label AS option',
                'pov.name AS option_value',
                'pa.product_option_value_price AS price'
            )
            ->join('product_options AS po','pa.product_option_id','=','po.id')
            ->join('product_option_values AS pov','pa.product_option_value_id','=','pov.id')
            ->where('pa.product_id',$productID)
            ->get();

        return view('admin.products.attributes',[
            'options' => ProductOption::all(),
            'productID' => $productID,
            'attributes' => $attributes
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()->with('success', 'Product sucessfully deleted');
    }

}