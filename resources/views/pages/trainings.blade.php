@extends('layouts.app')

@section('title', 'University Trainings - NCTU')

@section('content')

@push('styles')
<style>
    /* الـ CSS الخاص بتصميم الـ Polygonal والـ Diamonds */
    .training-banner {
        position: relative;
        width: 100%;
        min-height: 400px;
        margin-bottom: 50px;
        border-radius: 8px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        display: flex;
        background: #fff;
    }

    .training-banner .hero-image-container {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        z-index: 1;
        background-color: #f1f1f1;
    }

    .training-banner .hero-image-container img {
        width: 100%; height: 100%;
        object-fit: scale-down;
    }

    .training-banner.banner-dark .hero-image-container img { object-position: right center; }
    .training-banner.banner-blue .hero-image-container img { object-position: left center; }

    .bg-shape-main, .bg-shape-stripe {
        position: absolute;
        top: 0; bottom: 0;
    }

    /* Banner Dark Design */
    .banner-dark .bg-shape-main {
        left: 0; right: 0; z-index: 2;
        background: #ffffff;
        clip-path: polygon(0 0, 52% 0, 36% 100%, 0 100%);
    }

    .banner-dark .bg-shape-stripe {
        left: 0; right: 0; z-index: 3;
        background: #ffffff;
        clip-path: polygon(52% 0, 68% 0, 52% 100%, 36% 100%);
    }

    /* Banner Blue Design */
    .banner-blue .bg-shape-main {
        left: 0; right: 0; z-index: 2;
        background: #ffffff;
        clip-path: polygon(48% 0, 100% 0, 100% 100%, 64% 100%);
    }

    .banner-blue .bg-shape-stripe {
        left: 0; right: 0; z-index: 3;
        background: #ffffff;
        clip-path: polygon(32% 0, 48% 0, 64% 100%, 48% 100%);
    }

    .banner-content {
        position: relative;
        z-index: 5;
        display: flex;
        width: 100%;
    }

    .banner-blue .banner-content { flex-direction: row-reverse; }

    .banner-text-area {
        width: 45%;
        padding: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .date-highlight {
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 2px;
        margin-bottom: 15px;
        padding-left: 30px;
        position: relative;
        text-transform: uppercase;
        color: #D08301;
    }

    .date-highlight::before {
        content: '';
        position: absolute;
        left: 0; top: 50%;
        transform: translateY(-50%);
        width: 20px; height: 2px;
        background-color: #D08301;
    }

    .banner-text-area h3 {
        font-size: 1.5rem;
        font-weight: 900;
        color: #1a096e;
        text-transform: uppercase;
        margin-bottom: 25px;
    }

    .training-description {
        font-size: 0.95rem;
        line-height: 1.7;
        color: rgba(0, 0, 0, 0.85);
        max-height: 160px;
        overflow-y: auto;
    }

    /* Diamond Styles */
    .banner-visual-area { width: 55%; position: relative; }
    .diamond-cluster {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 290px; height: 140px;
    }

    .banner-dark .diamond-cluster { left: -10%; }
    .banner-blue .diamond-cluster { right: -10%; }

    .diamond-item {
        position: absolute;
        width: 95px; height: 95px;
        transform: rotate(45deg);
        overflow: hidden;
        border: 5px solid #1a096e;
        border-radius: 4px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        top: 22px;
    }

    .diamond-item img {
        width: 150%; height: 150%;
        object-fit: cover;
        transform: rotate(-45deg) scale(1.1);
        position: absolute;
        top: -25%; left: -25%;
    }

    .diamond-item:nth-child(1) { left: 15px; z-index: 10; }
    .diamond-item:nth-child(2) { left: 85px; z-index: 20; }
    .diamond-item:nth-child(3) { left: 155px; z-index: 30; }

    @media (max-width: 991px) {
        .training-banner { flex-direction: column !important; }
        .banner-content { flex-direction: column !important; }
        .banner-text-area { width: 100% !important; padding: 40px 30px; }
        .banner-visual-area { width: 100% !important; height: 350px; }
        .bg-shape-main, .bg-shape-stripe { display: none; }
        .diamond-cluster { left: 50% !important; transform: translate(-50%, -50%) scale(0.8); }
    }
</style>
@endpush

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Trainings</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Trainings</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Professional Development</h6>
            <h1 class="mb-5">University Training Programs</h1>
        </div>

        @php
            // Default fallback image
            $defaultImage = 'img/train-1.jpeg';
        @endphp

        @forelse($trainings as $index => $training)
            @php
                // Alternate banner type
                $bannerType = ($index % 2 == 0) ? 'banner-dark' : 'banner-blue';
                // Get first available image for main banner
                $mainImage = $training->image1 ?? $training->image2 ?? $training->image3 ?? $training->image4;
                $mainImage = $mainImage ? 'storage/' . $mainImage : $defaultImage;
                
                // Get all available images for diamond cluster
                $allImages = array_filter([
                    $training->image1,
                    $training->image2,
                    $training->image3,
                    $training->image4
                ]);
            @endphp
            
            <div class="training-banner {{ $bannerType }} wow fadeInUp" data-wow-delay="0.1s">
                <div class="hero-image-container">
                    <img src="{{ asset($mainImage) }}" alt="{{ $training->title }}">
                </div>
                <div class="bg-shape-main"></div>
                <div class="bg-shape-stripe"></div>

                <div class="banner-content">
                    <div class="banner-text-area">
                        <span class="date-highlight">{{ $training->start_date ? $training->start_date->format('F d, Y') : 'Date TBA' }}</span>
                        <h3>{{ $training->title }}</h3>
                        <p class="training-description">{{ $training->description }}</p>
                        @if($training->instructor)
                            <p class="text-muted small mt-2"><strong>Instructor:</strong> {{ $training->instructor }}</p>
                        @endif
                        @if($training->location)
                            <p class="text-muted small"><strong>Location:</strong> {{ $training->location }}</p>
                        @endif
                    </div>
                    <div class="banner-visual-area">
                        <div class="diamond-cluster">
                            @if(count($allImages) > 0)
                                @foreach(array_slice($allImages, 0, 3) as $img)
                                    <div class="diamond-item">
                                        <img src="{{ asset('storage/' . $img) }}" alt="">
                                    </div>
                                @endforeach
                            @else
                                <div class="diamond-item">
                                    <img src="{{ asset('img/train1-1.jpeg') }}" alt="">
                                </div>
                                <div class="diamond-item">
                                    <img src="{{ asset('img/train1-2.jpeg') }}" alt="">
                                </div>
                                <div class="diamond-item">
                                    <img src="{{ asset('img/train1-3.jpeg') }}" alt="">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-chalkboard-teacher fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">No trainings available</h3>
                <p class="text-muted">Check back soon for upcoming training programs!</p>
            </div>
        @endforelse

    </div>
</div>

@endsection
