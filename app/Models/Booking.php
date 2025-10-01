<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use \App\Models\Event;
use \App\Models\User;

/**
 * Booking model represents the many-to-many relationship between users and events.
 * Manages event attendance records with business logic for capacity tracking and booking validation.
 * Uses 'event_attendees' table to maintain clear semantic meaning in the database schema.
 */
class Booking extends Model
{
    protected $table = 'event_attendees';
    protected $fillable = ['event_id', 'user_id'];

    /**
     * Define inverse relationship to retrieve the event associated with this booking.
     * Enables access to full event details (title, date, location, etc.) from booking
     * records for display in user booking history and organizer reports.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    /**
     * Define inverse relationship to retrieve the user who made this booking.
     * Provides access to attendee information for event management purposes.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}