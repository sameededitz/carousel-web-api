<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slide extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'carousel_id',
        'type',
        'selected_tab',
        'content_orientation',
        'sub_title_text',
        'sub_title_is_enabled',
        'title_text',
        'title_is_enabled',
        'title_font_size',
        'cta_button_text',
        'cta_button_is_enabled',
        'description_text',
        'description_is_enabled',
        'description_font_size',
        'image_is_enabled',
        'image_opacity',
        'image_background_position',
        'image_is_bg_cover',
    ];

    protected $appends = ['image_src'];
    /**
     * Define the relationship to carousel.
     */
    public function carousel()
    {
        return $this->belongsTo(Carousel::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image_src')
            ->useDisk('media')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/bmp']);
    }

    public function getImageSrcAttribute()
    {
        $media = $this->getFirstMedia('image_src');
        return $media ? $media->getUrl() : null;
    }
}
