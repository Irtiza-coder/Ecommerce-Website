<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'short_description', 'description',
        'price', 'old_price', 'image', 'brand', 'stock_quantity', 'stock_status', 'is_featured',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return asset('images/product1.png');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        if (file_exists(public_path('images/' . $this->image))) {
            return asset('images/' . $this->image);
        }

        return asset('storage/' . $this->image);
    }
}