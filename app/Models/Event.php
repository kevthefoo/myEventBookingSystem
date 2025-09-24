<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'location',
        'capacity',
        'organizer_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    /**
     * Get the organizer that owns the event.
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * Get the attendees for the event.
     */
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_attendees')
                    ->withTimestamps();
    }

    /**
     * Check if the event is full.
     */
    public function isFull()
    {
        return $this->attendees()->count() >= $this->capacity;
    }

    /**
     * Get available spots for the event.
     */
    public function availableSpots()
    {
        return $this->capacity - $this->attendees()->count();
    }

    /**
     * Scope for upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString());
    }

    /**
     * Scope for past events.
     */
    public function scopePast($query)
    {
        return $query->where('date', '<', now()->toDateString());
    }
}