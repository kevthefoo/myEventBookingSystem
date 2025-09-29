<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'icon',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Automatically generate slug when creating category
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (!$category->slug) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationship: Many categories belong to many events
    public function events()
    {
        return $this->belongsToMany(Event::class)->withTimestamps();
    }

    // Scope for active categories only
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get events count for this category
    public function getEventsCountAttribute()
    {
        return $this->events()->count();
    }
}