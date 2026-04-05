@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">News</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">News</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Category Filter --}}
    <div class="container-xxl py-3">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-4">
                        <a href="{{ route('news.index') }}" class="btn btn-sm {{ !$category ? 'btn-primary' : 'btn-outline-primary' }} m-1">All</a>
                        @foreach($categories as $key => $label)
                            <a href="{{ route('news.index', ['category' => $key]) }}" class="btn btn-sm {{ $category === $key ? 'btn-primary' : 'btn-outline-primary' }} m-1">{{ $label }}</a>
                        @endforeach
                        <a href="{{ route('news.rss') }}" class="btn btn-sm btn-outline-secondary m-1">
                            <i class="fa fa-rss"></i> RSS Feed
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Featured News --}}
    @if($featuredNews->count() > 0 && !$category)
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-white text-center text-primary px-3">Featured</h6>
                    <h1 class="mb-5">Top Stories</h1>
                </div>
                
                <div class="row g-4">
                    @foreach($featuredNews as $article)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="course-item bg-light h-100">
                                <div class="position-relative overflow-hidden">
                                    @if($article->featuredImage)
                                        <img class="img-fluid" src="{{ asset('storage/' . $article->featuredImage->path) }}" alt="{{ $article->title }}" style="height: 250px; object-fit: cover; width: 100%;">
                                    @else
                                        <img class="img-fluid" src="{{ asset('img/default-news.jpg') }}" alt="{{ $article->title }}" style="height: 250px; object-fit: cover; width: 100%;">
                                    @endif
                                    <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                        <a href="{{ route('news.show', $article->slug) }}" class="flex-shrink-0 btn btn-sm btn-primary px-3">Read More</a>
                                    </div>
                                </div>
                                <div class="text-center p-4 pb-0">
                                    <span class="badge bg-primary mb-2">{{ ucfirst($article->category) }}</span>
                                    <h5 class="mb-3">{{ $article->title }}</h5>
                                    <p class="mb-3">{{ Str::limit($article->excerpt, 100) }}</p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2">
                                        <i class="fa fa-user text-primary me-2"></i>{{ $article->author->name }}
                                    </small>
                                    <small class="flex-fill text-center py-2">
                                        <i class="fa fa-calendar text-primary me-2"></i>{{ $article->published_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- All News --}}
    <div class="container-xxl py-5 {{ $featuredNews->count() > 0 && !$category ? 'bg-light' : '' }}">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title {{ $featuredNews->count() > 0 && !$category ? 'bg-light' : 'bg-white' }} text-center text-primary px-3">Latest News</h6>
                <h1 class="mb-5">Recent Updates</h1>
            </div>
            
            @if($news->count() > 0)
                <div class="row g-4">
                    @foreach($news as $article)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="course-item {{ $featuredNews->count() > 0 && !$category ? 'bg-white' : 'bg-light' }} h-100">
                                <div class="position-relative overflow-hidden">
                                    @if($article->featuredImage)
                                        <img class="img-fluid" src="{{ asset('storage/' . $article->featuredImage->path) }}" alt="{{ $article->title }}" style="height: 200px; object-fit: cover; width: 100%;">
                                    @else
                                        <img class="img-fluid" src="{{ asset('img/default-news.jpg') }}" alt="{{ $article->title }}" style="height: 200px; object-fit: cover; width: 100%;">
                                    @endif
                                    <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                        <a href="{{ route('news.show', $article->slug) }}" class="flex-shrink-0 btn btn-sm btn-primary px-3">Read More</a>
                                    </div>
                                </div>
                                <div class="text-center p-4 pb-0">
                                    <span class="badge bg-secondary mb-2">{{ ucfirst($article->category) }}</span>
                                    <h5 class="mb-3">{{ $article->title }}</h5>
                                    <p class="mb-3">{{ Str::limit($article->excerpt, 80) }}</p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2">
                                        <i class="fa fa-user text-primary me-2"></i>{{ $article->author->name }}
                                    </small>
                                    <small class="flex-fill text-center py-2">
                                        <i class="fa fa-calendar text-primary me-2"></i>{{ $article->published_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center">
                    <p class="text-muted">No news articles available at this time.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
