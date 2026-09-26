<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'company_name',
        'country',
        'address',
        'city',
        'order_notes',
        'subtotal',
        'shipping_fee',
        'total_amount',
        'payment_method',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(Signup::class, 'user_id');
    }
}
