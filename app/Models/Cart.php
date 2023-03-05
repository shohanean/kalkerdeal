<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['amount'];

    function relationshiptoproduct()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    function relationshiptocolor()
    {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }
    function relationshiptosize()
    {
        return $this->hasOne(Size::class, 'id', 'size_id');
    }
}
