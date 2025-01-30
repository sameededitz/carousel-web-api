<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentText extends Model
{
    protected $fillable = [
        'carousel_id',
        'is_custom_fonts_enabled',
        'primary_font_name',
        'primary_font_href',
        'secondary_font_name',
        'secondary_font_href',
        'font_size',
        'font_text_alignment',
    ];

    /**
     * Define the relationship to carousel.
     */
    public function carousel()
    {
        return $this->belongsTo(Carousel::class);
    }
}
