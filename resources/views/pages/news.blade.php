@extends('layouts.app')

@section('title', 'News - New Cairo University of Technology')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">News</h1>
                <nav aria-label="breadcrumb">
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- News Section -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Latest Updates</h6>
            <h1 class="mb-5">University News</h1>
        </div>
        <div class="row g-4">
            @forelse($news as $item)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="course-item bg-light">
                    @if($item->image)
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid" src="{{ asset($item->image) }}" alt="{{ $item->title }}">
                    </div>
                    @endif
                    <div class="text-center p-4 pb-0">
                        <h5 class="mb-3">{{ $item->title }}</h5>
                        <p>{{ Str::limit($item->excerpt, 100) }}</p>
                        <div class="mb-3">
                            <small class="text-muted"><i class="fa fa-calendar-alt text-primary me-2"></i>{{ $item->published_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-center">No news available at the moment.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- News Section End -->
@endsection
