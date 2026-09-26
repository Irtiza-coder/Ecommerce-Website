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
        $resolvedUrl = null;

        // 1. Check in public/images/
        if (file_exists(public_path('images/' . $cleanPath))) {
            $resolvedUrl = asset('images/' . $cleanPath);
        }
        // 2. Check in public/storage/
        elseif (file_exists(public_path('storage/' . $cleanPath))) {
            $resolvedUrl = asset('storage/' . $cleanPath);
        }
        // 3. Check directly in public/
        elseif (file_exists(public_path($cleanPath))) {
            $resolvedUrl = asset($cleanPath);
        }
        // 4. Try replacing .jpg/.jpeg with .png
        else {
            $pngPath = preg_replace('/\.(jpg|jpeg)$/i', '.png', $cleanPath);
            if (file_exists(public_path('images/' . $pngPath))) {
                $resolvedUrl = asset('images/' . $pngPath);
            } elseif (file_exists(public_path('storage/' . $pngPath))) {
                $resolvedUrl = asset('storage/' . $pngPath);
            } else {
                $jpgPath = preg_replace('/\.png$/i', '.jpg', $cleanPath);
                if (file_exists(public_path('images/' . $jpgPath))) {
                    $resolvedUrl = asset('images/' . $jpgPath);
                } elseif (file_exists(public_path('storage/' . $jpgPath))) {
                    $resolvedUrl = asset('storage/' . $jpgPath);
                } else {
                    $basename = basename($cleanPath);
                    $basenamePng = preg_replace('/\.(jpg|jpeg)$/i', '.png', $basename);
                    if (file_exists(public_path('images/products/' . $basenamePng))) {
                        $resolvedUrl = asset('images/products/' . $basenamePng);
                    } elseif (file_exists(public_path('images/products/' . $basename))) {
                        $resolvedUrl = asset('images/products/' . $basename);
                    }
                }
            }
        }

        if (!$resolvedUrl) {
            $resolvedUrl = asset('images/product1.png');
        }

        return $resolvedUrl . '?v=2';
    }
}