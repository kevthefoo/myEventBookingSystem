<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Booking;

/**
 * Event model represents upcoming events within the university booking system.
 * Manages event including creation, capacity tracking, categorization,
 * and attendee management.
 * Implements UUID-based routing for security
 */
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

    /**
     * Define inverse relationship to retrieve the organizer who creates the event.
     * Provides access to organizer details for event display, administrative purposes, and authorization checks.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * Define many-to-many relationship with users who have booked this event.
     * Represents actual attendees through the event_attendees pivot table.
     * Enable access to attendee lists for event management.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_attendees')
                    ->withTimestamps();
    }

    /**
     * Define one-to-many relationship with booking records for administrative tracking.
     * Provides access to individual booking instances.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'event_id');
    }


    /**
     * Define many-to-many relationship with categories for event classification.
     * Enables event organization where events can belong to multiple categories.
     * Support filtering by categories for better user experience.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }


    // Use UUID for route model binding
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}