<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Campus Events Report</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; max-width: 800px; }
        h2 { margin-top: 2rem; border-bottom: 1px solid #ccc; padding-bottom: .3rem; }
    </style>
</head>
<body>
    <h1>Campus Events Report</h1>

    <h2>Query 1: Every venue with the number of events it hosts</h2>
    <ul>
        @foreach ($venuesWithCounts as $v)
            <li>{{ $v->name }}: {{ $v->events_count }} events</li>
        @endforeach
    </ul>

    <h2>Query 2: All events at {{ $venue->name }}</h2>
    <ul>
        @foreach ($venueEvents as $e)
            <li>{{ $e->title }}</li>
        @endforeach
    </ul>

    <h2>Query 3: All participants of "{{ $event->title }}" with registration status</h2>
    <ul>
        @foreach ($eventParticipants as $p)
            <li>{{ $p->name }}: {{ $p->pivot->status }}</li>
        @endforeach
    </ul>

    <h2>Query 4: All events joined by {{ $participant->name }}</h2>
    <ul>
        @foreach ($participantEvents as $e)
            <li>{{ $e->title }} ({{ $e->pivot->status }})</li>
        @endforeach
    </ul>

    <h2>Query 5: Events with at least one waitlisted participant</h2>
    <ul>
        @foreach ($waitlistedEvents as $e)
            <li>{{ $e->title }}</li>
        @endforeach
    </ul>

    <h2>Query 6: Notes of "{{ $event->title }}" and of {{ $venue->name }}</h2>
    <strong>Event notes</strong>
    <ul>
        @foreach ($eventNotes as $n)
            <li>{{ $n->body }}</li>
        @endforeach
    </ul>
    <strong>Venue notes</strong>
    <ul>
        @foreach ($venueNotes as $n)
            <li>{{ $n->body }}</li>
        @endforeach
    </ul>

    <h2>Query 7: Note #{{ $note->id }} and what it belongs to</h2>
    <p>
        "{{ $note->body }}" belongs to a
        <strong>{{ class_basename($note->notable_type) }}</strong>:
        {{ $note->notable->title ?? $note->notable->name }}
    </p>
</body>
</html>