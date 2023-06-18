<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_detail extends Model
{
    use HasFactory;
    function relationshiptoproduct()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
