<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class,'status');
    }

    public function scopePaid($query)
    {
        $query->where('status', '<>', 2);
    }

    public function scopeDailySalesReport($query)
    {
        $query->paid()->whereRaw("DATE(created_at) = DATE(CONVERT_TZ(NOW(),'+01:00','+08:00'))")->latest();
    }

    public function scopeWeeklySalesReport($query)
    {
        $query->paid()->whereRaw('WEEKOFYEAR(created_at) = WEEKOFYEAR(NOW())')->latest();
    }

    public function scopeMonthlySalesReport($query)
    {
        $query->paid()->whereRaw('YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())')->latest();
    }

    public function scopeYearlySalesReport($query)
    {
        $query->paid()->whereRaw('YEAR(created_at) = YEAR(CURDATE())')->orderBy('id','DESC');
    }

}
