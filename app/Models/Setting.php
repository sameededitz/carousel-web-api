<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'carousel_id',
        'is_show_water_mark',
        'is_hide_intro_slide',
        'is_hide_outro_slide',
        'is_hide_counter',
    ];

    /**
     * Define the relationship to carousel.
     */
    public function carousel()
    {
        return $this->belongsTo(Carousel::class);
    }
}
