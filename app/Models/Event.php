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

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_attendees')
                    ->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'event_id');
    }

    // Add this relationship method
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