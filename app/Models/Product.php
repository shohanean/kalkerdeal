<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_thumbnail'];

    function relationshipwithuser(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    function relationshipwithcategory(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
