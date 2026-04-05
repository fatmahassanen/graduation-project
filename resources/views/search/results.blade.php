@extends('layouts.app')

@section('content')
    {{-- Search Results Header --}}
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="section-title bg-white text-center text-orange px-3">Search Results</h6>
                <h1 class="mb-3">Results for "{{ $query }}"</h1>
                <p class="text-muted">Found {{ $results->count() }} result(s)</p>
            </div>

            {{-- Search Filters --}}
            <div class="row mb-4">
                <div class="col-12">
                    <form action="{{ route('search') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" 
                                   class="form-control" 
                                   name="q" 
                                   value="{{ $query }}" 
                                   placeholder="Search..." 
                                   required>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="content_type">
                                <option value="">All Types</option>
                                <option value="pages" {{ $filters['content_type'] === 'pages' ? 'selected' : '' }}>Pages</option>
                                <option value="news" {{ $filters['content_type'] === 'news' ? 'selected' : '' }}>News</option>
                                <option value="events" {{ $filters['content_type'] === 'events' ? 'selected' : '' }}>Events</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="language">
                                <option value="en" {{ $filters['language'] === 'en' ? 'selected' : '' }}>English</option>
                                <option value="ar" {{ $filters['language'] === 'ar' ? 'selected' : '' }}>العربية</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" 
                                   class="form-control" 
                                   name="category" 
                                   value="{{ $filters['category'] ?? '' }}" 
                                   placeholder="Category">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100" style="background: #D08301; border-color: #D08301;">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Search Results --}}
            @if($results->count() > 0)
                <div class="row g-4">
                    @foreach($results as $result)
                        <div class="col-12">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    {{-- Result Type Badge --}}
                                    <span class="badge mb-2" 
                                          style="background: {{ $result['type'] === 'page' ? '#1a096e' : ($result['type'] === 'news' ? '#D08301' : '#28a745') }}">
                                        {{ ucfirst($result['type']) }}
                                    </span>

                                    {{-- Result Title with Highlighting --}}
                                    <h5 class="card-title">
                                        <a href="{{ $result['url'] }}" class="text-decoration-none" style="color: #1a096e;">
                                            {!! $result['highlighted_title'] !!}
                                        </a>
                                    </h5>

                                    {{-- Result Excerpt with Highlighting --}}
                                    <p class="card-text text-muted">
                                        {!! $result['highlighted_excerpt'] !!}
                                    </p>

                                    {{-- Result URL --}}
                                    <small class="text-muted">
                                        <i class="fas fa-link"></i> {{ $result['url'] }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- No Results Message --}}
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h4>No results found</h4>
                            <p class="mb-3">We couldn't find any results for "{{ $query }}"</p>
                            <p class="mb-0">
                                <strong>Suggestions:</strong>
                            </p>
                            <ul class="list-unstyled">
                                <li>Check your spelling</li>
                                <li>Try different keywords</li>
                                <li>Try more general keywords</li>
                                <li>Try fewer keywords</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    .search-highlight {
        background-color: #fff3cd;
        padding: 2px 4px;
        border-radius: 3px;
        font-weight: 600;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endpush
