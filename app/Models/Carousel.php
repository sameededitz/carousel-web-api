<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Carousel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'title',
        'options',
    ];

    protected $appends = ['image'];

    protected function casts(): array
    {
        return [
            'options' => 'array',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->useDisk('media')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/bmp']);
    }

    public function getImageAttribute()
    {
        $media = $this->getFirstMedia('image');
        return $media ? $media->getUrl() : null;
    }
}
