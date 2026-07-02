@extends('layouts.app')

@section('title', 'News - New Cairo University of Technology')

@push('styles')
<style>
/* ===== NEWS PAGE ===== */
.news-page-header {
    background: linear-gradient(rgba(10,15,40,0.78), rgba(10,15,40,0.78)),
                url('{{ asset('img/univercty2.jpg') }}') center/cover no-repeat;
    padding: 100px 0 70px;
    text-align: center;
}
.news-page-header h1 {
    font-size: clamp(2rem, 5vw, 3.2rem);
    font-weight: 800;
    color: #fff;
    margin: 0;
}
.news-breadcrumb {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 14px;
    font-size: 0.9rem;
    color: rgba(255,255,255,0.7);
}
.news-breadcrumb span { color: #D08301; font-weight: 600; }
.news-breadcrumb a { color: rgba(255,255,255,0.7); text-decoration: none; }

.news-label {
    display: inline-block;
    color: #D08301;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.news-section-title {
    font-size: clamp(1.7rem, 3vw, 2.2rem);
    font-weight: 800;
    color: #181d38;
    margin-bottom: 0;
}
.news-divider {
    width: 50px; height: 3px;
    background: #D08301;
    border-radius: 2px;
    margin: 14px auto 0;
}

/* News Card */
.n-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(24,29,56,0.07);
    height: 100%;
    min-height: 480px;
    display: flex;
    flex-direction: column;
    transition: transform 0.32s ease, box-shadow 0.32s ease;
    border-bottom: 3px solid transparent;
}
.n-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 45px rgba(24,29,56,0.14);
    border-bottom-color: #D08301;
}
.n-card-img {
    height: 220px;
    overflow: hidden;
    position: relative;
    flex-shrink: 0;
}
.n-card-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.n-card:hover .n-card-img img { transform: scale(1.07); }
.n-card-img-placeholder {
    height: 220px;
    background: linear-gradient(135deg, #1a3a6e 0%, #2356c7 100%);
    display: flex; align-items: center; justify-content: center;
}
.n-card-img-placeholder i { font-size: 3rem; color: rgba(255,255,255,0.4); }

.n-card-tag {
    position: absolute;
    top: 14px; left: 14px;
    background: #D08301;
    color: #fff;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 20px;
}
.n-card-body {
    padding: 24px 26px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.n-card-date {
    font-size: 0.75rem;
    color: #D08301;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}
.n-card-title {
    color: #181d38;
    font-weight: 700;
    font-size: 1.05rem;
    line-height: 1.45;
    margin-bottom: 12px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 3rem;
    flex-shrink: 0;
}
.n-card-description {
    color: #555;
    font-size: 0.88rem;
    line-height: 1.7;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    flex: 1;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #aaa;
}
.empty-state i { font-size: 4rem; margin-bottom: 16px; color: #ddd; }
.empty-state p { font-size: 1.1rem; }
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="news-page-header">
    <div class="container">
        <h1 class="animated slideInDown">University News</h1>
        <div class="news-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="bi bi-chevron-right" style="font-size:0.75rem;margin-top:2px;"></i>
            <span>News</span>
        </div>
    </div>
</div>

{{-- NEWS GRID --}}
<section class="py-5" style="background:#f4f7fc;">
    <div class="container">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <span class="news-label">Latest Updates</span>
            <h2 class="news-section-title">What's Happening at NCTU</h2>
            <div class="news-divider"></div>
        </div>

        <div class="row g-4">
            @forelse($news as $index => $item)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.05 + ($index * 0.08) }}s">
                <div class="n-card">
                    @if($item->image)
                        <div class="n-card-img position-relative">
                            <img src="{{ asset($item->image) }}" alt="{{ $item->title }}">
                            <span class="n-card-tag">News</span>
                        </div>
                    @else
                        <div class="n-card-img-placeholder position-relative">
                            <i class="fa fa-newspaper"></i>
                            <span class="n-card-tag" style="position:absolute;top:14px;left:14px;">News</span>
                        </div>
                    @endif
                    <div class="n-card-body">
                        <div>
                            <div class="n-card-date">
                                <i class="fa fa-calendar-alt"></i>
                                {{ $item->published_at ? $item->published_at->format('M d, Y') : $item->created_at->format('M d, Y') }}
                            </div>
                            <h5 class="n-card-title">{{ $item->title }}</h5>
                        </div>
                        <p class="n-card-description">{{ $item->excerpt }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fa fa-newspaper d-block"></i>
                    <p>No news available at the moment. Check back soon!</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
