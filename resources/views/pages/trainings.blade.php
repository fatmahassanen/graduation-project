@extends('layouts.app')

@section('title', 'University Trainings - NCTU')

@push('styles')
<style>
    .trainings-page-bg { background: #f4f7fc; }
    
    .training-section-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .training-section-header .t-label {
        display: inline-block;
        color: #D08301;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .training-section-header h2 {
        font-size: clamp(1.7rem, 3vw, 2.2rem);
        font-weight: 800;
        color: #181d38;
        margin-bottom: 0;
        text-align: center;
    }
    .training-section-header .t-divider {
        width: 50px; height: 3px;
        background: #D08301;
        border-radius: 2px;
        margin: 14px auto 0;
    }

    .training-card-horizontal {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(24,29,56,0.08);
        overflow: hidden;
        margin-bottom: 30px;
        display: flex;
        flex-direction: row;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .training-card-horizontal:hover {
        box-shadow: 0 8px 30px rgba(24,29,56,0.15);
        transform: translateY(-2px);
    }

    .training-card-image-left {
        width: 40%;
        min-height: 280px;
        background: #f1f1f1;
        overflow: hidden;
        flex-shrink: 0;
    }

    .training-card-image-left img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .training-card-content-right {
        width: 60%;
        padding: 35px 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .training-date-badge {
        display: inline-block;
        background: #D08301;
        color: #fff;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 6px 14px;
        border-radius: 20px;
        margin-bottom: 15px;
    }

    .training-card-content-right h3 {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1a096e;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .training-description-horizontal {
        font-size: 0.95rem;
        line-height: 1.7;
        color: rgba(0, 0, 0, 0.7);
        margin-bottom: 20px;
    }

    .training-meta-horizontal {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .training-meta-item-horizontal {
        display: flex;
        align-items: center;
        color: #666;
        font-size: 0.88rem;
    }

    .training-meta-item-horizontal i {
        color: #D08301;
        margin-right: 6px;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .training-card-horizontal {
            flex-direction: column;
        }
        .training-card-image-left {
            width: 100%;
            min-height: 220px;
        }
        .training-card-content-right {
            width: 100%;
            padding: 25px;
        }
        .training-card-content-right h3 {
            font-size: 1.3rem;
        }
    }
</style>
@endpush

@section('content')

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

<div class="trainings-page-bg">
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <div class="training-section-header">
                    <span class="t-label">Professional Development</span>
                    <h2>University Training Programs</h2>
                    <div class="t-divider"></div>
                </div>
            </div>

            @forelse($trainings as $index => $training)
                <div class="training-card-horizontal wow fadeInUp" data-wow-delay="{{ 0.1 * ($index % 3) }}s">
                    @if($training->image)
                        <div class="training-card-image-left">
                            <img src="{{ asset('storage/' . $training->image) }}" alt="{{ $training->title }}">
                        </div>
                    @endif

                    <div class="training-card-content-right">
                        @if($training->start_date)
                            <div class="training-date-badge">{{ $training->start_date->format('F d, Y') }}</div>
                        @endif
                        
                        <h3>{{ $training->title }}</h3>
                        
                        <p class="training-description-horizontal">{{ $training->description }}</p>

                        <div class="training-meta-horizontal">
                            @if($training->instructor)
                                <div class="training-meta-item-horizontal">
                                    <i class="fas fa-user-tie"></i>
                                    <span>{{ $training->instructor }}</span>
                                </div>
                            @endif
                            
                            @if($training->location)
                                <div class="training-meta-item-horizontal">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $training->location }}</span>
                                </div>
                            @endif
                            
                            @if($training->duration)
                                <div class="training-meta-item-horizontal">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $training->duration }} hrs</span>
                                </div>
                            @endif
                            
                            @if($training->capacity)
                                <div class="training-meta-item-horizontal">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $training->capacity }} seats</span>
                                </div>
                            @endif
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
</div>

@endsection
