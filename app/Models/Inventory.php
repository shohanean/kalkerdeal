<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    function relationshiptosize(){
        return $this->hasOne(Size::class, 'id', 'size_id');
    }
    function relationshiptocolor(){
        return $this->hasOne(Color::class, 'id', 'color_id');
    }
}
