<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Booking;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'title',
        'description',
        'date',
        'time',
        'location',
        'capacity',
        'organizer_id',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    // Auto-generate UUID when creating events
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($event) {
            if (empty($event->uuid)) {
                $event->uuid = (string) Str::uuid();
            }
        });
    }

    // Use UUID for route model binding
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function isFull()
    {
        return $this->attendees()->count() >= $this->capacity;
    }

    public function availableSpots()
    {
        return $this->capacity - $this->attendees()->count();
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString());
    }

    public function scopePast($query)
    {
        return $query->where('date', '<', now()->toDateString());
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_attendees')
                    ->withTimestamps();
    }

    // Add this relationship method
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    // Helper method to get category names as string
    public function getCategoryNamesAttribute()
    {
        return $this->categories->pluck('name')->join(', ');
    }

    // Scope to filter by category
    public function scopeWithCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'event_id');
    }

}