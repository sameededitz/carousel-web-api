<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackgroundOverlay extends Model
{
    protected $fillable = [
        'carousel_id',
        'background_id',
        'overlay_color',
        'overlay_opacity',
        'is_overlay_fade_corner',
        'corner_element_id',
        'corner_element_opacity',
    ];

    /**
     * Define the relationship to carousel.
     */
    public function carousel()
    {
        return $this->belongsTo(Carousel::class);
    }
}
