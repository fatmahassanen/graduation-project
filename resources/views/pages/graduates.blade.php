@extends('layouts.app')

@section('title', 'Graduate Achievements - New Cairo University of Technology')

@push('styles')
<style>
    .graduates-section {
        padding: 40px 0 60px;
        background: #f4f7fc;
    }
    .graduates-section-header {
        text-align: center;
        margin-bottom: 48px;
    }
    .graduates-section-header h2 {
        font-size: clamp(1.4rem, 3vw, 1.9rem);
        font-weight: 800;
        color: #181d38;
        margin-bottom: 0;
    }
    .graduates-section-header .g-divider {
        width: 50px; height: 3px;
        background: #D08301;
        border-radius: 2px;
        margin: 14px auto 0;
    }
    .item-container {
        display: flex;
        align-items: center;
        gap: 40px;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 6px 24px rgba(24,29,56,0.08);
        padding: 40px;
        margin-bottom: 40px;
        border-top: 4px solid #D08301;
        transition: box-shadow 0.3s ease;
    }
    .item-container:hover { box-shadow: 0 12px 36px rgba(24,29,56,0.14); }
    .left-img  { flex-direction: row; }
    .right-img { flex-direction: row-reverse; }
    .image-box {
        flex: 0 0 45%; max-width: 45%;
        border-radius: 16px; overflow: hidden;
        box-shadow: 0 4px 18px rgba(24,29,56,0.12);
        height: 320px;
    }
    .image-box img {
        width: 100%; height: 100%;
        object-fit: cover; display: block;
        transition: transform 0.45s ease;
    }
    .image-box:hover img { transform: scale(1.05); }
    .text-box { flex: 1; }
    .text-box h2 {
        font-size: 1.5rem; font-weight: 800; color: #181d38;
        border-left: 4px solid #D08301; padding-left: 14px;
        margin-bottom: 16px; line-height: 1.4;
    }
    .text-box p { font-size: 1rem; color: #555; line-height: 1.8; margin-bottom: 0; text-align: justify; }
    .graduates-empty { text-align: center; padding: 60px 20px; color: #888; font-size: 1.1rem; }
    @media (max-width: 768px) {
        .item-container { flex-direction: column !important; padding: 24px; gap: 24px; }
        .image-box { flex: 0 0 100%; max-width: 100%; height: 240px; width: 100%; }
        .text-box { width: 100%; }
        .text-box h2 { font-size: 1.25rem; }
    }
</style>
@endpush

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Graduate Achievements</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Graduates</li>
            </ol>
        </nav>
    </div>
</div>

<section class="graduates-section">
    <div class="container">
        <div class="graduates-section-header wow fadeInUp" data-wow-delay="0.1s">
            <h2>{{ $heroTitle }}</h2>
            <div class="g-divider"></div>
        </div>

        @forelse($graduates as $index => $graduate)
            @if($index % 2 == 0)
                <div class="item-container left-img wow fadeInUp" data-wow-delay="0.1s">
                    <div class="image-box">
                        @if($graduate->image)
                            <img src="{{ asset($graduate->image) }}" alt="{{ $graduate->title }}" loading="lazy">
                        @else
                            <img src="{{ asset('img/default-graduate.png') }}" alt="{{ $graduate->title }}" loading="lazy">
                        @endif
                    </div>
                    <div class="text-box">
                        <h2>{{ $graduate->title }}</h2>
                        <p>{{ $graduate->description }}</p>
                    </div>
                </div>
            @else
                <div class="item-container right-img wow fadeInUp" data-wow-delay="0.1s">
                    <div class="text-box">
                        <h2>{{ $graduate->title }}</h2>
                        <p>{{ $graduate->description }}</p>
                    </div>
                    <div class="image-box">
                        @if($graduate->image)
                            <img src="{{ asset($graduate->image) }}" alt="{{ $graduate->title }}" loading="lazy">
                        @else
                            <img src="{{ asset('img/default-graduate.png') }}" alt="{{ $graduate->title }}" loading="lazy">
                        @endif
                    </div>
                </div>
            @endif
        @empty
            <div class="graduates-empty">
                <i class="fas fa-graduation-cap fa-4x text-muted mb-3 d-block"></i>
                <p>No graduate achievements available at the moment.</p>
            </div>
        @endforelse
    </div>
</section>

@endsection
