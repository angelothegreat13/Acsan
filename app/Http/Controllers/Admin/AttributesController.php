<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Http\Controllers\Controller;

class AttributesController extends Controller
{
    public function index()
    {
        $options = ProductOption::with('productOptionValues')->get();

        return view('admin.attributes.index',compact('options'));
    }

    public function createOption()
    {
        return view('admin.attributes.create-option');
    }

    public function editOption(ProductOption $option)
    {
        return view('admin.attributes.edit-option',compact('option'));
    }

    public function updateOption(ProductOption $option)
    {
        $validated = request()->validate([
            'label' => ['required','min:2','unique:product_options,label,'.$option->id],
            'type' => ['required'],
        ]);

        $validated['name'] = Str::snake($validated['label']);
        $option->update($validated);
        
        return redirect(route('admin.attributes.index'))->with('success', 'Product option has been successfully updated');
    }

    public function storeOption()
    {
        $validated = request()->validate([
            'label' => ['required','min:2','unique:product_options,label'],
            'type' => ['required'],
        ]);

        $validated['name'] = Str::snake($validated['label']);
        ProductOption::create($validated);

        return redirect(route('admin.attributes.index'))->with('success', 'New Product option has been successfully saved');
    }

    public function destroyOption(ProductOption $option)
    {
        $option->delete();

        return redirect()->back()->with('success', 'Product option sucessfully deleted');
    }

    public function manageOptionValues($optionID)
    {
        return view('admin.attributes.manage-option-values',[
            'option' => ProductOption::where('id',$optionID)->with('productOptionValues')->first()
        ]);
    }

    public function storeOptionValue()
    {
        $optionValueExist = ProductOptionValue::where('product_option_id',request()->option_id)
            ->where('name',request()->name)
            ->count();

        if ($optionValueExist) {
            return back()->withErrors(['message' => 'Product option value already exist.'])->withInput();
        }

        ProductOptionValue::create([
            'product_option_id' => request()->option_id,
            'name' => request()->name
        ]);
        
        return redirect()->back()->with('success', 'New option value has been saved');
    }

    public function editOptionValue(ProductOptionValue $optionValue)
    {
        return $optionValue;
    }

    public function updateOptionValue(ProductOptionValue $optionValue)
    {
        $validated = request()->validate([
            'name' => ['required','min:2','unique:product_option_values,name,'.$optionValue->id],
        ]);
        
        $optionValue->name = $validated['name'];
        $optionValue->save();
        
        return redirect()->back()->with('success', 'Option value has been updated');
    }

    public function destroyOptionValue(ProductOptionValue $optionValue)
    {
        $optionValue->delete();

        return redirect()->back()->with('success', 'Product option value sucessfully deleted');
    }

}