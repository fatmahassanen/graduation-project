@extends('layouts.app')

@section('title', 'Student Activities - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Student Activities</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Activities</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Life at NCTU</h6>
            <h1 class="mb-5">Our Achievements & Events</h1>
        </div>

        <div class="row g-4">
            @forelse($activities as $index => $activity)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ ($index % 3) * 0.2 }}s">
                <div class="activity-card shadow-sm h-100 rounded-3 overflow-hidden bg-white">
                    <div class="position-relative overflow-hidden">
                        @if($activity->image)
                            <img class="img-fluid w-100" src="{{ $activity->image_url }}" alt="{{ $activity->title }}" style="height: 250px; object-fit: cover;">
                        @else
                            <img class="img-fluid w-100" src="{{ asset('img/activities1.jpg') }}" alt="{{ $activity->title }}" style="height: 250px; object-fit: cover;">
                        @endif
                        <div class="activity-overlay">
                            @if($activity->category)
                                <span class="badge bg-gold text-white px-3 py-2 rounded-pill">{{ $activity->category }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-3" style="color: #1a096e;">{{ $activity->title }}</h5>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">{{ $activity->description }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-trophy fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">No activities available</h3>
                <p class="text-muted">Check back soon for upcoming activities and achievements!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .activity-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border-top: 5px solid transparent;
    }
    .activity-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
        border-top: 5px solid var(--gold);
    }
    .activity-overlay {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2;
    }
    .bg-gold {
        background-color: #D08301 !important;
    }
    .activity-card img {
        transition: transform 0.5s ease;
    }
    .activity-card:hover img {
        transform: scale(1.1);
    }
</style>
@endpush
