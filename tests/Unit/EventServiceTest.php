<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\User;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventServiceTest extends TestCase
{
    use RefreshDatabase;

    protected EventService $eventService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventService = app(EventService::class);
    }

    public function test_get_upcoming_events_returns_only_future_events(): void
    {
        $user = User::factory()->create();

        // Create past event
        Event::factory()->create([
            'status' => 'published',
            'start_date' => now()->subDays(5),
            'end_date' => now()->subDays(4),
            'created_by' => $user->id,
        ]);

        // Create upcoming event
        $upcomingEvent = Event::factory()->create([
            'status' => 'published',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'created_by' => $user->id,
        ]);

        $events = $this->eventService->getUpcomingEvents();

        $this->assertCount(1, $events);
        $this->assertEquals($upcomingEvent->id, $events->first()->id);
    }

    public function test_get_past_events_returns_only_past_events(): void
    {
        $user = User::factory()->create();

        // Create past event
        $pastEvent = Event::factory()->create([
            'status' => 'published',
            'start_date' => now()->subDays(5),
            'end_date' => now()->subDays(4),
            'created_by' => $user->id,
        ]);

        // Create upcoming event
        Event::factory()->create([
            'status' => 'published',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'created_by' => $user->id,
        ]);

        $events = $this->eventService->getPastEvents();

        $this->assertCount(1, $events);
        $this->assertEquals($pastEvent->id, $events->first()->id);
    }

    public function test_get_upcoming_events_filters_by_category(): void
    {
        $user = User::factory()->create();

        Event::factory()->create([
            'status' => 'published',
            'category' => 'conference',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'created_by' => $user->id,
        ]);

        Event::factory()->create([
            'status' => 'published',
            'category' => 'workshop',
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(8),
            'created_by' => $user->id,
        ]);

        $events = $this->eventService->getUpcomingEvents('conference');

        $this->assertCount(1, $events);
        $this->assertEquals('conference', $events->first()->category);
    }

    public function test_export_to_icalendar_generates_valid_format(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'status' => 'published',
            'title' => 'Test Event',
            'description' => 'Test Description',
            'location' => 'Test Location',
            'created_by' => $user->id,
        ]);

        $ical = $this->eventService->exportToICalendar($event);

        $this->assertStringContainsString('BEGIN:VCALENDAR', $ical);
        $this->assertStringContainsString('VERSION:2.0', $ical);
        $this->assertStringContainsString('BEGIN:VEVENT', $ical);
        $this->assertStringContainsString('SUMMARY:Test Event', $ical);
        $this->assertStringContainsString('DESCRIPTION:Test Description', $ical);
        $this->assertStringContainsString('LOCATION:Test Location', $ical);
        $this->assertStringContainsString('END:VEVENT', $ical);
        $this->assertStringContainsString('END:VCALENDAR', $ical);
    }

    public function test_export_to_icalendar_includes_recurrence_rule(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'status' => 'published',
            'is_recurring' => true,
            'recurrence_rule' => 'FREQ=WEEKLY;INTERVAL=1',
            'created_by' => $user->id,
        ]);

        $ical = $this->eventService->exportToICalendar($event);

        $this->assertStringContainsString('RRULE:FREQ=WEEKLY;INTERVAL=1', $ical);
    }

    public function test_generate_recurring_instances_creates_multiple_events(): void
    {
        $user = User::factory()->create();
        $startDate = Carbon::parse('2024-01-01 10:00:00');
        
        $event = Event::factory()->create([
            'status' => 'published',
            'is_recurring' => true,
            'recurrence_rule' => 'FREQ=WEEKLY;INTERVAL=1',
            'start_date' => $startDate,
            'end_date' => $startDate->copy()->addHours(2),
            'created_by' => $user->id,
        ]);

        $instances = $this->eventService->generateRecurringInstances(
            $event,
            $startDate,
            $startDate->copy()->addWeeks(3)
        );

        $this->assertGreaterThan(1, $instances->count());
    }

    public function test_get_upcoming_events_orders_by_start_date(): void
    {
        $user = User::factory()->create();

        $event1 = Event::factory()->create([
            'status' => 'published',
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(11),
            'created_by' => $user->id,
        ]);

        $event2 = Event::factory()->create([
            'status' => 'published',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'created_by' => $user->id,
        ]);

        $events = $this->eventService->getUpcomingEvents();

        $this->assertEquals($event2->id, $events->first()->id);
        $this->assertEquals($event1->id, $events->last()->id);
    }

    public function test_get_upcoming_events_respects_limit(): void
    {
        $user = User::factory()->create();

        Event::factory()->count(5)->create([
            'status' => 'published',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'created_by' => $user->id,
        ]);

        $events = $this->eventService->getUpcomingEvents(null, 'en', 3);

        $this->assertCount(3, $events);
    }
}
