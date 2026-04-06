<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EventService
{
    /**
     * Get upcoming events ordered by start_date.
     * Requirements: 13.2, 13.3
     */
    public function getUpcomingEvents(?string $category = null, ?string $language = 'en', ?int $limit = null): Collection
    {
        $query = Event::query()
            ->where('status', 'published')
            ->where('language', $language)
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->with(['image', 'creator']);

        if ($category) {
            $query->where('category', $category);
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get past events ordered by start_date descending.
     * Requirements: 13.3
     */
    public function getPastEvents(?string $category = null, ?string $language = 'en', ?int $limit = null): Collection
    {
        $query = Event::query()
            ->where('status', 'published')
            ->where('language', $language)
            ->where('start_date', '<', now())
            ->orderBy('start_date', 'desc')
            ->with(['image', 'creator']);

        if ($category) {
            $query->where('category', $category);
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Generate recurring event instances based on recurrence rule.
     * Requirements: 13.7, 13.8
     */
    public function generateRecurringInstances(Event $event, Carbon $startDate, Carbon $endDate): Collection
    {
        if (!$event->is_recurring || !$event->recurrence_rule) {
            return collect([$event]);
        }

        $instances = collect();
        $rule = $this->parseRecurrenceRule($event->recurrence_rule);

        $currentDate = $startDate->copy();
        $eventDuration = $event->start_date->diffInSeconds($event->end_date);

        while ($currentDate->lte($endDate)) {
            // Create a virtual instance (not persisted)
            $instance = new Event($event->toArray());
            $instance->start_date = $currentDate->copy();
            $instance->end_date = $currentDate->copy()->addSeconds($eventDuration);
            $instance->id = $event->id . '-' . $currentDate->format('Ymd');
            
            $instances->push($instance);

            // Move to next occurrence based on rule
            $currentDate = $this->getNextOccurrence($currentDate, $rule);

            // Safety limit to prevent infinite loops
            if ($instances->count() > 365) {
                break;
            }
        }

        return $instances;
    }

    /**
     * Export event to iCalendar format.
     * Requirements: 13.9
     */
    public function exportToICalendar(Event $event): string
    {
        $ical = "BEGIN:VCALENDAR\r\n";
        $ical .= "VERSION:2.0\r\n";
        $ical .= "PRODID:-//University CMS//Event Calendar//EN\r\n";
        $ical .= "CALSCALE:GREGORIAN\r\n";
        $ical .= "METHOD:PUBLISH\r\n";
        
        $ical .= "BEGIN:VEVENT\r\n";
        $ical .= "UID:" . $event->id . "@" . config('app.url') . "\r\n";
        $ical .= "DTSTAMP:" . now()->format('Ymd\THis\Z') . "\r\n";
        $ical .= "DTSTART:" . $event->start_date->format('Ymd\THis\Z') . "\r\n";
        $ical .= "DTEND:" . $event->end_date->format('Ymd\THis\Z') . "\r\n";
        $ical .= "SUMMARY:" . $this->escapeICalText($event->title) . "\r\n";
        $ical .= "DESCRIPTION:" . $this->escapeICalText($event->description) . "\r\n";
        
        if ($event->location) {
            $ical .= "LOCATION:" . $this->escapeICalText($event->location) . "\r\n";
        }
        
        if ($event->is_recurring && $event->recurrence_rule) {
            $ical .= "RRULE:" . $event->recurrence_rule . "\r\n";
        }
        
        $ical .= "STATUS:CONFIRMED\r\n";
        $ical .= "END:VEVENT\r\n";
        
        $ical .= "END:VCALENDAR\r\n";
        
        return $ical;
    }

    /**
     * Export multiple events to iCalendar format.
     */
    public function exportMultipleToICalendar(Collection $events): string
    {
        $ical = "BEGIN:VCALENDAR\r\n";
        $ical .= "VERSION:2.0\r\n";
        $ical .= "PRODID:-//University CMS//Event Calendar//EN\r\n";
        $ical .= "CALSCALE:GREGORIAN\r\n";
        $ical .= "METHOD:PUBLISH\r\n";
        
        foreach ($events as $event) {
            $ical .= "BEGIN:VEVENT\r\n";
            $ical .= "UID:" . $event->id . "@" . config('app.url') . "\r\n";
            $ical .= "DTSTAMP:" . now()->format('Ymd\THis\Z') . "\r\n";
            $ical .= "DTSTART:" . $event->start_date->format('Ymd\THis\Z') . "\r\n";
            $ical .= "DTEND:" . $event->end_date->format('Ymd\THis\Z') . "\r\n";
            $ical .= "SUMMARY:" . $this->escapeICalText($event->title) . "\r\n";
            $ical .= "DESCRIPTION:" . $this->escapeICalText($event->description) . "\r\n";
            
            if ($event->location) {
                $ical .= "LOCATION:" . $this->escapeICalText($event->location) . "\r\n";
            }
            
            if ($event->is_recurring && $event->recurrence_rule) {
                $ical .= "RRULE:" . $event->recurrence_rule . "\r\n";
            }
            
            $ical .= "STATUS:CONFIRMED\r\n";
            $ical .= "END:VEVENT\r\n";
        }
        
        $ical .= "END:VCALENDAR\r\n";
        
        return $ical;
    }

    /**
     * Parse recurrence rule (simplified iCalendar RRULE format).
     */
    protected function parseRecurrenceRule(string $rule): array
    {
        $parsed = [
            'freq' => 'DAILY',
            'interval' => 1,
            'count' => null,
            'until' => null,
        ];

        $parts = explode(';', $rule);
        
        foreach ($parts as $part) {
            if (strpos($part, '=') !== false) {
                [$key, $value] = explode('=', $part, 2);
                $key = strtoupper(trim($key));
                $value = trim($value);
                
                switch ($key) {
                    case 'FREQ':
                        $parsed['freq'] = strtoupper($value);
                        break;
                    case 'INTERVAL':
                        $parsed['interval'] = (int) $value;
                        break;
                    case 'COUNT':
                        $parsed['count'] = (int) $value;
                        break;
                    case 'UNTIL':
                        $parsed['until'] = Carbon::parse($value);
                        break;
                }
            }
        }

        return $parsed;
    }

    /**
     * Get next occurrence based on recurrence rule.
     */
    protected function getNextOccurrence(Carbon $date, array $rule): Carbon
    {
        $interval = $rule['interval'] ?? 1;
        
        switch ($rule['freq']) {
            case 'DAILY':
                return $date->addDays($interval);
            case 'WEEKLY':
                return $date->addWeeks($interval);
            case 'MONTHLY':
                return $date->addMonths($interval);
            case 'YEARLY':
                return $date->addYears($interval);
            default:
                return $date->addDays($interval);
        }
    }

    /**
     * Escape text for iCalendar format.
     * Strip HTML tags and escape special characters.
     */
    protected function escapeICalText(string $text): string
    {
        // Strip HTML tags
        $text = strip_tags($text);
        
        // Remove newlines and escape special characters
        $text = str_replace(["\r\n", "\n", "\r"], ' ', $text);
        $text = str_replace(['\\', ',', ';'], ['\\\\', '\\,', '\\;'], $text);
        
        return $text;
    }
}
