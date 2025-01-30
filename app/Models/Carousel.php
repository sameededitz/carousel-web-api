<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $fillable = [
        'user_id',
        'locale',
        'current_index',
        'zoom_value',
        'slide_ratio_id',
        'slide_ratio_width',
        'slide_ratio_height',
    ];

    /**
     * Define the relationship to the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship to slides.
     */
    public function slides()
    {
        return $this->hasMany(Slide::class);
    }

    /**
     * Define the relationship to content texts.
     */
    public function contentText()
    {
        return $this->hasOne(ContentText::class);
    }

    /**
     * Define the relationship to colors.
     */
    public function colors()
    {
        return $this->hasOne(Color::class);
    }

    /**
     * Define the relationship to brand.
     */
    public function brand()
    {
        return $this->hasOne(Brand::class);
    }

    /**
     * Define the relationship to background overlay.
     */
    public function backgroundOverlay()
    {
        return $this->hasOne(BackgroundOverlay::class);
    }

    /**
     * Define the relationship to settings.
     */
    public function settings()
    {
        return $this->hasOne(Setting::class);
    }

    /**
     * Define the relationship to arrow texts.
     */
    public function arrowText()
    {
        return $this->hasOne(ArrowText::class);
    }
}
