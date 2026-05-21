@extends('layouts.app')

@section('title', 'Gallery - New Cairo University of Technology')

@section('content')

@push('styles')
<style>
    :root {
        --blue: #1a096e;
        --gold: #D08301;
    }

    /* Body */
    body {
        font-family: 'Heebo', sans-serif;
        background-color: #f8f9fc;
        color: #333;
        scroll-behavior: smooth;
    }

    /* Header Customization */
    .page-header {
        color: #fff;
        text-align: center;
        padding: 120px 20px 80px;
    }

    .page-header h1 {
        font-size: 4rem;
        font-weight: 900;
        color: var(--gold);
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
    }

    /* Gallery Styles */
    .gallery-container {
        padding: 60px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .gallery-section-title {
        text-align: center;
        color: var(--blue);
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 40px;
        position: relative;
        padding-bottom: 15px;
        margin-top: 20px;
    }

    .gallery-section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background-color: var(--gold);
        border-radius: 2px;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 80px;
    }

    .gallery-card {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        position: relative;
        border-bottom: 4px solid transparent;
    }

    .gallery-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        border-bottom: 4px solid var(--gold);
    }

    .gallery-img-wrapper {
        position: relative;
        width: 100%;
        padding-top: 75%; /* 4:3 Aspect Ratio */
        background-color: #f1f3f5;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gallery-img-wrapper i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3.5rem;
        color: #dee2e6;
        z-index: 1;
    }

    .gallery-img-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
        z-index: 2;
    }

    .gallery-img-wrapper img[src=""] {
        opacity: 0;
    }

    .gallery-card:hover .gallery-img-wrapper img {
        transform: scale(1.1);
    }

    @media(max-width: 992px) {
        .page-header h1 {
            font-size: 3rem;
        }
    }
</style>
@endpush

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Gallery</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Gallery</li>
            </ol>
        </nav>
    </div>
</div>
<div class="gallery-container">
    @if($images->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-images fa-4x text-muted mb-3"></i>
            <h3 class="text-muted">No gallery images available</h3>
            <p class="text-muted">Check back soon for updates!</p>
        </div>
    @else
        @php
            $groupedImages = $images->groupBy(function($image) {
                return $image->category ?? 'Uncategorized';
            });
        @endphp

        @foreach($groupedImages as $category => $categoryImages)
            <h2 class="gallery-section-title">{{ $category }}</h2>
            <div class="gallery-grid">
                @foreach($categoryImages as $index => $image)
                <div class="gallery-card wow fadeInUp" data-wow-delay="{{ 0.1 * ($index % 3) }}s">
                    <div class="gallery-img-wrapper">
                        <i class="fas fa-image"></i>
                        @if($image->image)
                            <img src="{{ asset($image->image) }}" alt="{{ $image->title }}">
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach
    @endif
</div>
@endsection
