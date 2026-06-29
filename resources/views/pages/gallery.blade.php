@extends('layouts.app')

@section('title', 'Gallery - New Cairo University of Technology')

@push('styles')
<style>
    .gallery-page-bg {
        background: #f4f7fc;
        min-height: 60vh;
        padding: 60px 0 80px;
    }
    .gallery-section-title {
        text-align: center;
        font-size: 1.8rem;
        font-weight: 800;
        color: #181d38;
        margin-bottom: 32px;
        margin-top: 48px;
        position: relative;
        padding-bottom: 16px;
    }
    .gallery-section-title:first-of-type { margin-top: 0; }
    .gallery-section-title::after {
        content: '';
        position: absolute;
        bottom: 0; left: 50%;
        transform: translateX(-50%);
        width: 50px; height: 3px;
        background: #D08301;
        border-radius: 2px;
    }
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 16px;
    }
    @media (max-width: 991px) { .gallery-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575px)  { .gallery-grid { grid-template-columns: 1fr; } }

    .gallery-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(24,29,56,0.08);
        transition: transform 0.35s ease, box-shadow 0.35s ease;
        cursor: pointer;
        position: relative;
    }
    .gallery-card:hover { transform: translateY(-8px); box-shadow: 0 12px 36px rgba(24,29,56,0.18); }

    .gallery-img-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: #e9ecef;
        display: flex; align-items: center; justify-content: center;
    }
    .gallery-img-wrapper img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
        display: block;
    }
    .gallery-card:hover .gallery-img-wrapper img { transform: scale(1.08); }

    .gallery-zoom-overlay {
        position: absolute; inset: 0;
        background: rgba(24,29,56,0.25);
        display: flex; align-items: center; justify-content: center;
        opacity: 0;
        transition: opacity 0.35s ease;
        z-index: 3;
    }
    .gallery-card:hover .gallery-zoom-overlay { opacity: 1; }
    .gallery-zoom-overlay .zoom-icon {
        width: 52px; height: 52px;
        background: rgba(255,255,255,0.75);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; color: #181d38;
    }
    .gallery-img-wrapper .placeholder-icon { font-size: 3rem; color: #ced4da; }

    .gallery-empty { text-align: center; padding: 80px 20px; }

    /* Lightbox */
    #gallery-lightbox {
        display: none;
        position: fixed; inset: 0;
        background: rgba(10,10,20,0.92);
        z-index: 9999;
        align-items: center; justify-content: center;
    }
    #gallery-lightbox.active { display: flex; }
    #gallery-lightbox img {
        max-width: 90vw; max-height: 88vh;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 8px 48px rgba(0,0,0,0.6);
        animation: lb-zoom-in 0.25s ease;
    }
    @keyframes lb-zoom-in {
        from { transform: scale(0.88); opacity: 0; }
        to   { transform: scale(1);    opacity: 1; }
    }
    #gallery-lightbox-close {
        position: fixed; top: 20px; right: 28px;
        background: rgba(255,255,255,0.15);
        border: 2px solid rgba(255,255,255,0.4);
        color: #fff; font-size: 1.6rem; line-height: 1;
        width: 44px; height: 44px; border-radius: 50%;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.2s; z-index: 10000;
    }
    #gallery-lightbox-close:hover { background: rgba(208,131,1,0.8); border-color: #D08301; }
</style>
@endpush

@section('content')

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

<div class="gallery-page-bg">
    <div class="container">
        @if($images->isEmpty())
            <div class="gallery-empty">
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
                    <div class="gallery-card wow fadeInUp" data-wow-delay="{{ 0.1 * ($index % 3) }}s"
                         @if($image->image) onclick="openLightbox('{{ asset($image->image) }}', '{{ addslashes($image->title) }}')" @endif>
                        <div class="gallery-img-wrapper">
                            @if($image->image)
                                <img src="{{ asset($image->image) }}" alt="{{ $image->title }}">
                                <div class="gallery-zoom-overlay">
                                    <span class="zoom-icon"><i class="fas fa-eye"></i></span>
                                </div>
                            @else
                                <i class="fas fa-image placeholder-icon"></i>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</div>

<div id="gallery-lightbox" role="dialog" aria-modal="true">
    <button id="gallery-lightbox-close" onclick="closeLightbox()" aria-label="Close">&times;</button>
    <img id="gallery-lightbox-img" src="" alt="">
</div>

@endsection

@push('scripts')
<script>
(function() {
    var lb    = document.getElementById('gallery-lightbox');
    var lbImg = document.getElementById('gallery-lightbox-img');
    window.openLightbox = function(src, alt) {
        lbImg.src = src; lbImg.alt = alt || '';
        lb.classList.add('active');
        document.body.style.overflow = 'hidden';
    };
    window.closeLightbox = function() {
        lb.classList.remove('active');
        lbImg.src = '';
        document.body.style.overflow = '';
    };
    lb.addEventListener('click', function(e) { if (e.target === lb) closeLightbox(); });
    document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeLightbox(); });
})();
</script>
@endpush
