<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $guarded = [];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_participant')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}