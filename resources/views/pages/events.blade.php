@extends('layouts.app')

@section('title', 'Events - New Cairo University of Technology')

@push('styles')
<style>
/* ===== EVENTS PAGE ===== */
.events-page-header {
    background: linear-gradient(rgba(10,15,40,0.78), rgba(10,15,40,0.78)),
                url('{{ asset('img/univercty2.jpg') }}') center/cover no-repeat;
    padding: 100px 0 70px;
    text-align: center;
}
.events-page-header h1 {
    font-size: clamp(2rem, 5vw, 3.2rem);
    font-weight: 800;
    color: #fff;
    margin: 0;
}
.events-breadcrumb {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 14px;
    font-size: 0.9rem;
    color: rgba(255,255,255,0.7);
}
.events-breadcrumb span { color: #D08301; font-weight: 600; }
.events-breadcrumb a { color: rgba(255,255,255,0.7); text-decoration: none; }

.events-label {
    display: inline-block;
    color: #D08301;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.events-section-title {
    font-size: clamp(1.7rem, 3vw, 2.2rem);
    font-weight: 800;
    color: #181d38;
    margin-bottom: 0;
}
.events-divider {
    width: 50px; height: 3px;
    background: #D08301;
    border-radius: 2px;
    margin: 14px auto 0;
}

/* Event Card */
.e-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(24,29,56,0.07);
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: transform 0.32s ease, box-shadow 0.32s ease;
}
.e-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 45px rgba(24,29,56,0.14);
}
.e-card-img {
    height: 260px;
    overflow: hidden;
    position: relative;
}
.e-card-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.e-card:hover .e-card-img img { transform: scale(1.07); }
.e-card-date-badge {
    position: absolute;
    top: 14px; right: 14px;
    background: #D08301;
    color: #fff;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    letter-spacing: 0.5px;
}
.e-card-body {
    padding: 22px 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
    border-top: 3px solid #D08301;
}
.e-card-body h4 {
    color: #181d38;
    font-weight: 700;
    font-size: 1.05rem;
    line-height: 1.4;
    margin-bottom: 10px;
}
.e-card-body p {
    color: #555;
    font-size: 0.88rem;
    line-height: 1.7;
    flex: 1;
    margin-bottom: 18px;
}
.e-card-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #181d38;
    color: #fff;
    padding: 9px 22px;
    border-radius: 6px;
    font-size: 0.84rem;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.3s, transform 0.2s;
    align-self: flex-start;
}
.e-card-btn:hover {
    background: #D08301;
    color: #fff;
    transform: translateX(3px);
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #aaa;
}
.empty-state i { font-size: 4rem; margin-bottom: 16px; color: #ddd; display: block; }
.empty-state p { font-size: 1.1rem; }
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="events-page-header">
    <div class="container">
        <h1 class="animated slideInDown">University Events</h1>
        <div class="events-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="bi bi-chevron-right" style="font-size:0.75rem;margin-top:2px;"></i>
            <span>Events</span>
        </div>
    </div>
</div>

{{-- EVENTS GRID --}}
<section class="py-5" style="background:#f4f7fc;">
    <div class="container">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <span class="events-label">Our Activities</span>
            <h2 class="events-section-title">Events & Activities at NCTU</h2>
            <div class="events-divider"></div>
            <p class="mt-3" style="color:#555;font-size:0.95rem;max-width:560px;margin:12px auto 0;">
                Explore our diverse range of events, conferences, trainings, and student activities.
            </p>
        </div>

        <div class="row g-4">
            @forelse($events as $index => $event)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.05 + ($index * 0.08) }}s">
                <div class="e-card">
                    <div class="e-card-img">
                        @if($event->image)
                            <img src="{{ asset($event->image) }}" alt="{{ $event->title }}"
                                 onerror="this.src='{{ asset('img/Events/Conferences.jpg') }}'">
                        @else
                            <img src="{{ asset('img/Events/Conferences.jpg') }}" alt="{{ $event->title }}">
                        @endif
                        <span class="e-card-date-badge">
                            <i class="fa fa-calendar-alt me-1"></i>{{ $event->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <div class="e-card-body">
                        <h4>{{ Str::limit($event->title, 55) }}</h4>
                        <p>{{ Str::limit($event->description, 120) }}</p>
                        <a href="{{ $event->link }}" class="e-card-btn">
                            View Details <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fa fa-calendar-times"></i>
                    <p>No events available at the moment. Check back soon!</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
