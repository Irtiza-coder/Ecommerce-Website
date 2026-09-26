<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    protected $fillable = ['section', 'title', 'subtitle', 'description', 'image'];
    public static function getSection(string $section): self
    {
        return self::firstOrNew(['section' => $section]);
    }
}
