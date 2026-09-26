<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testmonials extends Model
{
    protected $fillable = [
        'name',
        'role',
        'review',
        'rating',
        'image',
        'status',
    ];
}
