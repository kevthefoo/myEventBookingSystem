<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Category model represents event classification system for better user experience.
 * Manages event categorization with visual styling (colors, icons) to organize events by type or theme.
 * Enables filtering functionality for better user experience.
 */
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

    /**
     * Define many-to-many relationship with events for flexible categorization.
     * Allows events to have multiple categories
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_categories');
    }

    /**
     * Scope query to retrieve only active categories.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Retrieve hexadecimal color value by selected color on color palette.
     * @return string Valid hexadecimal color code (EX: #FF5733)
     */
    public function getColorAttribute($value)
    {
        // Ensure color starts with # for CSS compatibility
        return $value && !str_starts_with($value, '#') ? '#' . $value : ($value ?? '#6B7280');
    }
}