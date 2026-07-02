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

<section class="py-5" style="background:#f4f7fc;">
    <div class="container">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <span class="act-badge">Life at NCTU</span>
            <h2 class="act-heading">Our Achievements & Events</h2>
            <div class="act-divider mx-auto"></div>
        </div>

        <div class="row g-4">
            @forelse($activities as $index => $activity)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ ($index % 3) * 0.2 }}s">
                <div class="act-card h-100">
                    <div class="act-img-wrap">
                        @if($activity->image)
                            <img class="act-img w-100" src="{{ $activity->image_url }}" alt="{{ $activity->title }}">
                        @else
                            <img class="act-img w-100" src="{{ asset('img/activities1.jpg') }}" alt="{{ $activity->title }}">
                        @endif
                        @if($activity->category)
                            <span class="act-category-badge">{{ $activity->category }}</span>
                        @endif
                    </div>
                    <div class="act-body">
                        <h5 class="act-title">{{ $activity->title }}</h5>
                        <p class="act-desc">{{ $activity->description }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-trophy fa-4x text-muted mb-3 d-block"></i>
                <h3 class="text-muted">No activities available</h3>
                <p class="text-muted">Check back soon for upcoming activities and achievements!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .act-badge {
        display: inline-block;
        color: #D08301;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 10px;
    }
    .act-heading {
        font-weight: 800;
        color: #181d38;
        font-size: clamp(1.6rem,3vw,2.2rem);
        margin-bottom: 14px;
    }
    .act-divider {
        width: 50px; height: 4px;
        background: #D08301;
        border-radius: 2px;
        margin-top: 4px;
    }
    .act-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(24,29,56,0.07);
        border-top: 4px solid transparent;
        display: flex;
        flex-direction: column;
        transition: transform 0.35s cubic-bezier(0.165,0.84,0.44,1),
                    box-shadow 0.35s cubic-bezier(0.165,0.84,0.44,1),
                    border-top-color 0.25s;
    }
    .act-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 18px 48px rgba(24,29,56,0.14);
        border-top-color: #D08301;
    }
    .act-img-wrap { position: relative; overflow: hidden; flex-shrink: 0; }
    .act-img {
        height: 240px;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }
    .act-card:hover .act-img { transform: scale(1.08); }
    .act-category-badge {
        position: absolute;
        top: 14px; right: 14px;
        z-index: 2;
        background: #D08301;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 20px;
        letter-spacing: 0.5px;
    }
    .act-body {
        padding: 22px 24px 26px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .act-title {
        color: #181d38;
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    .act-desc {
        color: #555;
        font-size: 0.9rem;
        line-height: 1.7;
        margin-bottom: 0;
        flex: 1;
    }
</style>
@endpush
