@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">{{ $news->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('news.index') }}">News</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">{{ Str::limit($news->title, 50) }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- News Article --}}
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                {{-- Article Content --}}
                <div class="col-lg-8">
                    {{-- Article Meta --}}
                    <div class="mb-4">
                        <span class="badge bg-primary me-2">{{ ucfirst($news->category) }}</span>
                        <small class="text-muted">
                            <i class="fa fa-user me-1"></i>{{ $news->author->name }}
                        </small>
                        <small class="text-muted ms-3">
                            <i class="fa fa-calendar me-1"></i>{{ $news->published_at->format('F d, Y') }}
                        </small>
                    </div>

                    {{-- Featured Image --}}
                    @if($news->featured_image)
                        <img class="img-fluid rounded mb-4" src="{{ asset($news->featured_image) }}" alt="{{ $news->title }}">
                    @elseif($news->featuredImage)
                        <img class="img-fluid rounded mb-4" src="{{ asset('storage/' . $news->featuredImage->path) }}" alt="{{ $news->title }}">
                    @else
                        <img class="img-fluid rounded mb-4" src="{{ asset('img/default-news.jpg') }}" alt="{{ $news->title }}">
                    @endif

                    {{-- Article Excerpt --}}
                    <div class="mb-4">
                        <p class="lead">{{ $news->excerpt }}</p>
                    </div>

                    {{-- Article Body --}}
                    <div class="mb-4">
                        {!! $news->body !!}
                    </div>

                    {{-- Share Buttons --}}
                    <div class="border-top pt-4 mt-4">
                        <h6 class="mb-3">Share this article:</h6>
                        <div class="d-flex">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('news.show', $news->slug)) }}" target="_blank" class="btn btn-primary btn-sm me-2">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('news.show', $news->slug)) }}&text={{ urlencode($news->title) }}" target="_blank" class="btn btn-info btn-sm me-2">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('news.show', $news->slug)) }}&title={{ urlencode($news->title) }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="fab fa-linkedin-in"></i> LinkedIn
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    {{-- Related News --}}
                    @if($relatedNews->count() > 0)
                        <div class="bg-light rounded p-4 mb-4">
                            <h5 class="mb-4">Related News</h5>
                            
                            @foreach($relatedNews as $related)
                                <div class="d-flex mb-3 pb-3 border-bottom">
                                    @if($related->featured_image)
                                        <img class="img-fluid rounded" src="{{ asset($related->featured_image) }}" alt="{{ $related->title }}" style="width: 80px; height: 80px; object-fit: cover;">
                                    @elseif($related->featuredImage)
                                        <img class="img-fluid rounded" src="{{ asset('storage/' . $related->featuredImage->path) }}" alt="{{ $related->title }}" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <img class="img-fluid rounded" src="{{ asset('img/default-news.jpg') }}" alt="{{ $related->title }}" style="width: 80px; height: 80px; object-fit: cover;">
                                    @endif
                                    <div class="ps-3">
                                        <h6 class="mb-1">
                                            <a href="{{ route('news.show', $related->slug) }}" class="text-dark">
                                                {{ Str::limit($related->title, 60) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">{{ $related->published_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Categories --}}
                    <div class="bg-light rounded p-4 mb-4">
                        <h5 class="mb-4">Categories</h5>
                        <div class="d-flex flex-column">
                            <a href="{{ route('news.index', ['category' => 'announcement']) }}" class="btn btn-outline-primary btn-sm mb-2">Announcements</a>
                            <a href="{{ route('news.index', ['category' => 'achievement']) }}" class="btn btn-outline-primary btn-sm mb-2">Achievements</a>
                            <a href="{{ route('news.index', ['category' => 'research']) }}" class="btn btn-outline-primary btn-sm mb-2">Research</a>
                            <a href="{{ route('news.index', ['category' => 'partnership']) }}" class="btn btn-outline-primary btn-sm">Partnerships</a>
                        </div>
                    </div>

                    {{-- Back to News --}}
                    <div class="text-center">
                        <a href="{{ route('news.index') }}" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left me-2"></i>Back to News
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
