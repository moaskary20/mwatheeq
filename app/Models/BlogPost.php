<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'image',
        'sort_order',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (BlogPost $post): void {
            if (blank($post->slug)) {
                $slug = Str::slug($post->title);

                $post->slug = filled($slug)
                    ? $slug
                    : 'post-'.Str::lower(Str::random(6));
            }

            if (blank($post->published_at) && $post->is_published) {
                $post->published_at = now();
            }
        });

        static::updating(function (BlogPost $post): void {
            if ($post->is_published && blank($post->published_at)) {
                $post->published_at = now();
            }
        });
    }

    public function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class)->latest();
    }

    public function approvedComments(): HasMany
    {
        return $this->hasMany(BlogComment::class)
            ->where('is_approved', true)
            ->latest();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (blank($this->image)) {
            return null;
        }

        $path = is_array($this->image)
            ? collect($this->image)->filter()->first()
            : $this->image;

        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'image/')) {
            return asset($path);
        }

        return asset('storage/'.$path);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
