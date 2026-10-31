# Campus Events (Week 10: Relational Data Model & Queries)

A small Laravel + PostgreSQL app where venues host events, participants register for events, and notes can be attached to either an event or a venue.

## Relationships

| Link | Type | Model/table that holds the foreign key | Relationship methods | ON DELETE | Why |
|---|---|---|---|---|---|
| Venue and Event | One-to-many | `events.venue_id` (Event) | `Venue::events()` (hasMany), `Event::venue()` (belongsTo) | RESTRICT | A venue that still has events must not be deletable. |
| Event and Participant | Many-to-many | `event_participant` pivot table (`event_id`, `participant_id`, plus `status`) | `Event::participants()`, `Participant::events()` (both belongsToMany) | CASCADE (both keys) | Deleting an event or a participant must remove their registrations. |
| Note and Event/Venue | Polymorphic one-to-many | `notes.notable_id` + `notes.notable_type` (Note) | `Note::notable()` (morphTo), `Event::notes()` and `Venue::notes()` (morphMany) | None (no database foreign key) | PostgreSQL cannot have one foreign key point to two tables, so only application code can check that the target exists. |

The pivot table uses a composite primary key (`event_id`, `participant_id`), so the same participant cannot register for the same event twice.

## Setup

1. Copy `.env.example` to `.env` and set your PostgreSQL database name, username and password.
2. `composer install`
3. `php artisan key:generate`
4. `php artisan migrate:fresh --seed`
5. `php artisan serve`, then open `http://127.0.0.1:8000/report`