<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Note;
use App\Models\Participant;
use App\Models\Venue;

class ReportController extends Controller
{
    public function index()
    {
        // The "one chosen" items. Change them with ?venue=2&event=3&participant=4&note=5
        $venue       = Venue::findOrFail(request('venue', 1));
        $event       = Event::findOrFail(request('event', 1));
        $participant = Participant::findOrFail(request('participant', 1));
        $note        = Note::with('notable')->findOrFail(request('note', 1));

        return view('report', [
            'venue'       => $venue,
            'event'       => $event,
            'participant' => $participant,
            'note'        => $note,

            // Q1: every venue with the number of events it hosts
            'venuesWithCounts' => Venue::withCount('events')->get(),

            // Q2: all events at one chosen venue
            'venueEvents' => $venue->events,

            // Q3: all participants of one chosen event, with registration status
            'eventParticipants' => $event->participants,

            // Q4: all events one chosen participant has joined
            'participantEvents' => $participant->events,

            // Q5: events with at least one waitlisted participant
            'waitlistedEvents' => Event::whereHas('participants', function ($q) {
                $q->where('event_participant.status', 'waitlisted');
            })->get(),

            // Q6: all notes of one event, and all notes of one venue
            'eventNotes' => $event->notes,
            'venueNotes' => $venue->notes,
        ]);
    }
}