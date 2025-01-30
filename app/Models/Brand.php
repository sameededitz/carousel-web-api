<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Brand extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'carousel_id',
        'is_show_in_intro_slide',
        'is_show_in_outro_slide',
        'is_show_in_regular_slide',
        'name_text',
        'name_is_enabled',
        'handle_text',
        'handle_is_enabled',
        'profile_image_is_enabled',
    ];

    protected $appends = ['profile_image_src'];

    /**
     * Define the relationship to carousel.
     */
    public function carousel()
    {
        return $this->belongsTo(Carousel::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_image_src')
            ->useDisk('media')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/bmp']);
    }

    public function getProfileImageSrcAttribute()
    {
        $media = $this->getFirstMedia('profile_image_src');
        return $media ? $media->getUrl() : null;
    }
}
