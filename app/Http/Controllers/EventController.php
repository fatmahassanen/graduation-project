<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct(
        protected EventService $eventService
    ) {
    }

    /**
     * Display a listing of events.
     * Requirements: 13.2, 13.4, 13.5
     */
    public function index(Request $request): View
    {
        $language = $request->get('lang', 'en');
        $category = $request->get('category');

        $upcomingEvents = $this->eventService->getUpcomingEvents($category, $language);
        $pastEvents = $this->eventService->getPastEvents($category, $language, 10);

        $categories = [
            'competition' => 'Competition',
            'conference' => 'Conference',
            'exhibition' => 'Exhibition',
            'workshop' => 'Workshop',
            'seminar' => 'Seminar',
        ];

        return view('events.index', compact('upcomingEvents', 'pastEvents', 'categories', 'category'));
    }

    /**
     * Display the specified event.
     * Requirements: 13.2, 13.6
     */
    public function show(Request $request, string $id): View
    {
        $event = Event::where('id', $id)
            ->where('status', 'published')
            ->with(['image', 'creator'])
            ->firstOrFail();

        return view('events.show', compact('event'));
    }

    /**
     * Export event to iCalendar format.
     * Requirements: 13.9
     */
    public function exportIcal(string $id): Response
    {
        $event = Event::where('id', $id)
            ->where('status', 'published')
            ->firstOrFail();

        $ical = $this->eventService->exportToICalendar($event);

        return response($ical, 200)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="event-' . $event->id . '.ics"');
    }

    /**
     * Export all upcoming events to iCalendar format.
     */
    public function exportAllIcal(Request $request): Response
    {
        $language = $request->get('lang', 'en');
        $category = $request->get('category');

        $events = $this->eventService->getUpcomingEvents($category, $language);

        $ical = $this->eventService->exportMultipleToICalendar($events);

        return response($ical, 200)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="events.ics"');
    }
}
