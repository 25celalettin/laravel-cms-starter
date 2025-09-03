<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'user_id',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();
     
        static::deleting(function ($blog) {
            $blog->deleteImage();
        });
    }

    public function deleteImage()
    {
        if ($this->image) {
            $imagePath = str_replace('storage/', '', $this->image);
            Storage::disk('public')->delete($imagePath);
        }
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCoverImage()
    {
        return $this->image ? asset($this->image) : 'https://placehold.co/600x400';
    }
}
