<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use \App\Models\Event;
use \App\Models\User;

class Booking extends Model
{
    protected $table = 'event_attendees';
    protected $fillable = ['event_id', 'user_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}