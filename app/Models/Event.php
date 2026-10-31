<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'event_participant')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }
}