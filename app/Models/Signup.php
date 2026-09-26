<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signup extends Model{
    protected $table = 'signups';

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
