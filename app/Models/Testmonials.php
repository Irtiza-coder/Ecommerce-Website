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

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                return $this->image;
            }

            $clean = ltrim($this->image, '/');

            // 1. Check in public/images/
            if (file_exists(public_path('images/' . $clean))) {
                return asset('images/' . $clean) . '?v=2';
            }

            // 2. Check in public/images/testimonials/
            $basename = basename($clean);
            if (file_exists(public_path('images/testimonials/' . $basename))) {
                return asset('images/testimonials/' . $basename) . '?v=2';
            }

            // 3. Check directly in public/storage/
            if (file_exists(public_path('storage/' . $clean))) {
                return asset('storage/' . $clean) . '?v=2';
            }

            // 4. Check directly in public/
            if (file_exists(public_path($clean))) {
                return asset($clean) . '?v=2';
            }
        }

        // Auto-match by name slug in public/images/testimonials/
        $slug = \Illuminate\Support\Str::slug($this->name);
        if (file_exists(public_path('images/testimonials/' . $slug . '.png'))) {
            return asset('images/testimonials/' . $slug . '.png') . '?v=2';
        }
        if (file_exists(public_path('images/testimonials/' . $slug . '.jpg'))) {
            return asset('images/testimonials/' . $slug . '.jpg') . '?v=2';
        }

        return asset('images/Layer_23_copy_5.png');
    }
}
