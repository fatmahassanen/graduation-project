@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Events</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Events</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Category Filter --}}
    <div class="container-xxl py-3">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-4">
                        <a href="{{ route('events.index') }}" class="btn btn-sm {{ !$category ? 'btn-primary' : 'btn-outline-primary' }} m-1">All</a>
                        @foreach($categories as $key => $label)
                            <a href="{{ route('events.index', ['category' => $key]) }}" class="btn btn-sm {{ $category === $key ? 'btn-primary' : 'btn-outline-primary' }} m-1">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Upcoming Events --}}
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Upcoming Events</h6>
                <h1 class="mb-5">What's Coming Up</h1>
            </div>
            
            @if($upcomingEvents->count() > 0)
                <div class="row g-4">
                    @foreach($upcomingEvents as $event)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="course-item bg-light">
                                <div class="position-relative overflow-hidden">
                                    @if($event->featured_image)
                                        <img class="img-fluid" src="{{ asset($event->featured_image) }}" alt="{{ $event->title }}">
                                    @elseif($event->image)
                                        <img class="img-fluid" src="{{ asset('storage/' . $event->image->path) }}" alt="{{ $event->title }}">
                                    @else
                                        <img class="img-fluid" src="{{ asset('img/default-event.jpg') }}" alt="{{ $event->title }}">
                                    @endif
                                    <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                        <a href="{{ route('events.show', $event->id) }}" class="flex-shrink-0 btn btn-sm btn-primary px-3">View Details</a>
                                    </div>
                                </div>
                                <div class="text-center p-4 pb-0">
                                    <span class="badge bg-primary mb-2">{{ ucfirst($event->category) }}</span>
                                    <h5 class="mb-3">{{ $event->title }}</h5>
                                    <div class="mb-3">
                                        <small class="fa fa-calendar text-primary me-2"></small>
                                        <small>{{ $event->start_date->format('M d, Y') }}</small>
                                        @if($event->location)
                                            <br>
                                            <small class="fa fa-map-marker-alt text-primary me-2"></small>
                                            <small>{{ $event->location }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2">
                                        <i class="fa fa-clock text-primary me-2"></i>{{ $event->start_date->format('h:i A') }}
                                    </small>
                                    <small class="flex-fill text-center py-2">
                                        <div class="dropdown">
                                            <a href="#" class="text-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="fa fa-calendar-plus me-2"></i>Add to Calendar
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="https://calendar.google.com/calendar/render?action=TEMPLATE&text={{ urlencode($event->title) }}&dates={{ $event->start_date->format('Ymd\THis\Z') }}/{{ $event->end_date->format('Ymd\THis\Z') }}&details={{ urlencode($event->description) }}&location={{ urlencode($event->location ?? '') }}" target="_blank">
                                                        <i class="fab fa-google me-2"></i>Google Calendar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="https://outlook.live.com/calendar/0/deeplink/compose?subject={{ urlencode($event->title) }}&startdt={{ $event->start_date->toIso8601String() }}&enddt={{ $event->end_date->toIso8601String() }}&body={{ urlencode($event->description) }}&location={{ urlencode($event->location ?? '') }}" target="_blank">
                                                        <i class="fab fa-microsoft me-2"></i>Outlook
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('events.export', $event->id) }}">
                                                        <i class="fa fa-download me-2"></i>Download .ics
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center">
                    <p class="text-muted">No upcoming events at this time.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Past Events --}}
    @if($pastEvents->count() > 0)
        <div class="container-xxl py-5 bg-light">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-light text-center text-primary px-3">Past Events</h6>
                    <h1 class="mb-5">Recent Activities</h1>
                </div>
                
                <div class="row g-4">
                    @foreach($pastEvents as $event)
                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="course-item bg-white">
                                <div class="position-relative overflow-hidden">
                                    @if($event->featured_image)
                                        <img class="img-fluid" src="{{ asset($event->featured_image) }}" alt="{{ $event->title }}" style="height: 200px; object-fit: cover; width: 100%;">
                                    @elseif($event->image)
                                        <img class="img-fluid" src="{{ asset('storage/' . $event->image->path) }}" alt="{{ $event->title }}" style="height: 200px; object-fit: cover; width: 100%;">
                                    @else
                                        <img class="img-fluid" src="{{ asset('img/default-event.jpg') }}" alt="{{ $event->title }}" style="height: 200px; object-fit: cover; width: 100%;">
                                    @endif
                                </div>
                                <div class="text-center p-3">
                                    <h6 class="mb-2">{{ $event->title }}</h6>
                                    <small class="text-muted">{{ $event->start_date->format('M d, Y') }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
