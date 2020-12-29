<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function totalQty()
    {
        if (empty(session('customer_id'))) {
            return self::where('session_id',Session::getId())->where('is_order',0)->sum('quantity');
        } else {
            return self::where('customer_id',session('customer_id'))->where('is_order',0)->sum('quantity');
        }
    }

    public static function total()
    {
        if (empty(session('customer_id'))) {
            return self::where('session_id',Session::getId())->where('is_order',0)->sum('final_price');
        } else {
            return self::where('customer_id',session('customer_id'))->where('is_order',0)->sum('final_price');
        }
    }

}