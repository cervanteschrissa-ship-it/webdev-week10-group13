<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 3 venues
        $venues = collect([
            ['Main Hall', 'Los Baños'],
            ['Science Auditorium', 'Calamba'],
            ['Open Grounds', 'Santa Rosa'],
        ])->map(fn ($v) => Venue::create(['name' => $v[0], 'city' => $v[1]]));

        // 6 events (2 per venue)
        $events = collect([
            ['Orientation', 0],
            ['Hackathon', 0],
            ['Science Fair', 1],
            ['Career Day', 1],
            ['Sports Fest', 2],
            ['Music Night', 2],
        ])->map(fn ($e, $i) => Event::create([
            'title'     => $e[0],
            'venue_id'  => $venues[$e[1]]->id,
            'starts_at' => now()->addDays($i + 1),
        ]));

        // 8 participants
        $participants = collect(['Ana', 'Ben', 'Carla', 'Dan', 'Ella', 'Finn', 'Gina', 'Hugo'])
            ->map(fn ($n) => Participant::create([
                'name'  => $n,
                'email' => strtolower($n) . '@example.com',
            ]));

        // 12 registrations: [event index, participant index, status]
        $registrations = [
            [0, 0, 'registered'], [0, 1, 'registered'], [0, 2, 'waitlisted'],
            [1, 0, 'registered'], [1, 3, 'registered'],
            [2, 4, 'registered'], [2, 5, 'waitlisted'],
            [3, 1, 'registered'], [3, 6, 'registered'],
            [4, 7, 'registered'],
            [5, 2, 'registered'], [5, 3, 'waitlisted'],
        ];

        foreach ($registrations as [$e, $p, $status]) {
            $events[$e]->participants()->attach($participants[$p]->id, ['status' => $status]);
        }

        // 6 notes: 3 on events, 3 on venues (created through the relationships)
        $events[0]->notes()->create(['body' => 'Bring your student ID.']);
        $events[1]->notes()->create(['body' => 'Teams of four only.']);
        $events[2]->notes()->create(['body' => 'Judges arrive at 9 AM.']);
        $venues[0]->notes()->create(['body' => 'Aircon is broken.']);
        $venues[1]->notes()->create(['body' => 'Projector is available.']);
        $venues[2]->notes()->create(['body' => 'No power outlets nearby.']);
    }
}