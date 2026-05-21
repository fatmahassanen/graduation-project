@extends('layouts.app')

@section('title', 'Events - New Cairo University of Technology')

@section('content')
<style>
    .read-more-btn {
        display: inline-block;
        background-color: #D08301;
        color: #fff;
        padding: 10px 10px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 15px;
        transition: all 0.3s ease;
    }

    .read-more-btn:hover {
        background-color: #b66f01;
        color: #fff;
        transform: scale(1.05);
    }

    .event-category-card {
        background: #fff;
        padding: 40px 30px;
        border-radius: 15px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: all 0.3s ease;
        border-top: 4px solid #D08301;
        height: 100%;
        margin-bottom: 30px;
    }

    .event-category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .card-icon {
        color: #D08301;
        margin-bottom: 20px;
    }

    .event-category-card h3 {
        color: #1a096e;
        margin-bottom: 15px;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .event-category-card p {
        color: #5d6d7e;
        line-height: 1.6;
        margin-bottom: 20px;
        font-size: 1rem;
    }

    .btn-event {
        background: #D08301;
        color: white;
        padding: 10px 25px;
        border: none;
        border-radius: 25px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-event:hover {
        background: #b36f00;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(210, 131, 1, 0.4);
    }
</style>

<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Events</h1>
                <nav aria-label="breadcrumb">
                    <!--<ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="home.html">Home</a></li>
                    </ol>-->
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Events Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Our Activities</h6>
            <h1 class="mb-5">University Events & Activities</h1>
            <p class="mb-5">Explore our diverse range of events, conferences, trainings, and student activities.</p>
        </div>

        <!-- Events Cards -->
        <div class="row g-4">
            @forelse($events as $index => $event)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index * 0.1) }}s">
                <div class="event-category-card">
                    <div class="card-icon">
                        @if($event->image)
                            <img src="{{ asset($event->image) }}" alt="{{ $event->title }}"
                                style="width: 280px; height: 200px; object-fit: cover; border-radius: 10px;">
                        @else
                            <img src="{{ asset('img/Events/Conferences.jpg') }}" alt="{{ $event->title }}"
                                style="width: 280px; height: 200px; object-fit: cover; border-radius: 10px;">
                        @endif
                    </div>
                    <h3>{{ Str::limit($event->title, 40) }}</h3>
                    <p>{{ Str::limit($event->description, 120) }}</p>
                    <a href="{{ $event->link }}" class="btn-event">View Details</a>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <p class="mb-0">No events available at the moment. Check back soon!</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Events End -->
@endsection
