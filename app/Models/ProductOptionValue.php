<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class);
    }

}
