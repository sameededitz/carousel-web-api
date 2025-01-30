<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'carousel_id',
        'is_use_custom_colors',
        'is_alternate_slide_colors',
        'background_color',
        'text_color',
        'accent_color',
    ];

    /**
     * Define the relationship to carousel.
     */
    public function carousel()
    {
        return $this->belongsTo(Carousel::class);
    }
}
