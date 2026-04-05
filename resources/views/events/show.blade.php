@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">{{ $event->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('events.index') }}">Events</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">{{ $event->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Event Details --}}
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                {{-- Event Image --}}
                <div class="col-lg-8">
                    @if($event->featured_image)
                        <img class="img-fluid rounded mb-4" src="{{ asset($event->featured_image) }}" alt="{{ $event->title }}">
                    @elseif($event->image)
                        <img class="img-fluid rounded mb-4" src="{{ asset('storage/' . $event->image->path) }}" alt="{{ $event->title }}">
                    @else
                        <img class="img-fluid rounded mb-4" src="{{ asset('img/default-event.jpg') }}" alt="{{ $event->title }}">
                    @endif

                    {{-- Event Description --}}
                    <div class="mb-4">
                        <h3 class="mb-3">About This Event</h3>
                        <p class="text-muted" style="white-space: pre-line;">{{ $event->description }}</p>
                    </div>
                </div>

                {{-- Event Sidebar --}}
                <div class="col-lg-4">
                    <div class="bg-light rounded p-4 mb-4">
                        <h5 class="mb-4">Event Details</h5>
                        
                        {{-- Category --}}
                        <div class="d-flex mb-3">
                            <i class="fa fa-tag text-primary me-3 mt-1"></i>
                            <div>
                                <h6 class="mb-0">Category</h6>
                                <small class="text-muted">{{ ucfirst($event->category) }}</small>
                            </div>
                        </div>

                        {{-- Start Date --}}
                        <div class="d-flex mb-3">
                            <i class="fa fa-calendar text-primary me-3 mt-1"></i>
                            <div>
                                <h6 class="mb-0">Start Date</h6>
                                <small class="text-muted">{{ $event->start_date->format('l, F d, Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $event->start_date->format('h:i A') }}</small>
                            </div>
                        </div>

                        {{-- End Date --}}
                        <div class="d-flex mb-3">
                            <i class="fa fa-calendar-check text-primary me-3 mt-1"></i>
                            <div>
                                <h6 class="mb-0">End Date</h6>
                                <small class="text-muted">{{ $event->end_date->format('l, F d, Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $event->end_date->format('h:i A') }}</small>
                            </div>
                        </div>

                        {{-- Location --}}
                        @if($event->location)
                            <div class="d-flex mb-3">
                                <i class="fa fa-map-marker-alt text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-0">Location</h6>
                                    <small class="text-muted">{{ $event->location }}</small>
                                </div>
                            </div>
                        @endif

                        {{-- Recurring Event --}}
                        @if($event->is_recurring)
                            <div class="d-flex mb-3">
                                <i class="fa fa-redo text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-0">Recurring Event</h6>
                                    <small class="text-muted">This event repeats</small>
                                </div>
                            </div>
                        @endif

                        {{-- Add to Calendar Button --}}
                        <div class="mt-4">
                            <h6 class="mb-3">Add to Calendar</h6>
                            
                            {{-- Google Calendar --}}
                            <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text={{ urlencode($event->title) }}&dates={{ $event->start_date->format('Ymd\THis\Z') }}/{{ $event->end_date->format('Ymd\THis\Z') }}&details={{ urlencode($event->description) }}&location={{ urlencode($event->location ?? '') }}" 
                               target="_blank" 
                               class="btn btn-outline-primary w-100 mb-2">
                                <i class="fab fa-google me-2"></i>Google Calendar
                            </a>

                            {{-- Outlook Calendar --}}
                            <a href="https://outlook.live.com/calendar/0/deeplink/compose?subject={{ urlencode($event->title) }}&startdt={{ $event->start_date->toIso8601String() }}&enddt={{ $event->end_date->toIso8601String() }}&body={{ urlencode($event->description) }}&location={{ urlencode($event->location ?? '') }}" 
                               target="_blank" 
                               class="btn btn-outline-primary w-100 mb-2">
                                <i class="fab fa-microsoft me-2"></i>Outlook Calendar
                            </a>

                            {{-- Download .ics file --}}
                            <a href="{{ route('events.export', $event->id) }}" 
                               class="btn btn-outline-secondary w-100">
                                <i class="fa fa-download me-2"></i>Download .ics File
                            </a>
                            <small class="text-muted d-block mt-2 text-center">
                                .ics works with Apple Calendar, Outlook, and other calendar apps
                            </small>
                        </div>
                    </div>

                    {{-- Back to Events --}}
                    <div class="text-center">
                        <a href="{{ route('events.index') }}" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left me-2"></i>Back to Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
