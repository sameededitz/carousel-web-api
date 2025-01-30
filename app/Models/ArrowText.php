<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArrowText extends Model
{
    protected $fillable = [
        'carousel_id',
        'arrow_id',
        'is_only_arrow',
        'intro_slide_arrow_text',
        'intro_slide_arrow_is_enabled',
        'regular_slide_arrow_text',
        'regular_slide_arrow_is_enabled',
    ];

    /**
     * Define the relationship to carousel.
     */
    public function carousel()
    {
        return $this->belongsTo(Carousel::class);
    }
}
