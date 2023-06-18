<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    function relationshiptouser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
