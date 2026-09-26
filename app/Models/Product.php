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

        $cleanPath = ltrim($this->image, '/');

        // 1. Check in public/images/
        if (file_exists(public_path('images/' . $cleanPath))) {
            return asset('images/' . $cleanPath);
        }

        // 2. Check in public/storage/
        if (file_exists(public_path('storage/' . $cleanPath))) {
            return asset('storage/' . $cleanPath);
        }

        // 3. Check directly in public/
        if (file_exists(public_path($cleanPath))) {
            return asset($cleanPath);
        }

        // 4. Try replacing .jpg/.jpeg with .png
        $pngPath = preg_replace('/\.(jpg|jpeg)$/i', '.png', $cleanPath);
        if (file_exists(public_path('images/' . $pngPath))) {
            return asset('images/' . $pngPath);
        }
        if (file_exists(public_path('storage/' . $pngPath))) {
            return asset('storage/' . $pngPath);
        }

        // 5. Try replacing .png with .jpg
        $jpgPath = preg_replace('/\.png$/i', '.jpg', $cleanPath);
        if (file_exists(public_path('images/' . $jpgPath))) {
            return asset('images/' . $jpgPath);
        }
        if (file_exists(public_path('storage/' . $jpgPath))) {
            return asset('storage/' . $jpgPath);
        }

        // 6. Check by basename in public/images/products/
        $basename = basename($cleanPath);
        $basenamePng = preg_replace('/\.(jpg|jpeg)$/i', '.png', $basename);
        if (file_exists(public_path('images/products/' . $basenamePng))) {
            return asset('images/products/' . $basenamePng);
        }
        if (file_exists(public_path('images/products/' . $basename))) {
            return asset('images/products/' . $basename);
        }

        return asset('images/product1.png');
    }
}