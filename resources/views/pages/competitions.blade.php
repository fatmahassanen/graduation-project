@extends('layouts.app')

@section('title', 'Competitions - New Cairo University of Technology')

@section('content')
<style>
    .competition-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 40px;
        border-left: 5px solid #D08301;
    }

    .competition-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .competition-content {
        display: flex;
        align-items: stretch;
        padding: 0;
        min-height: 400px;
    }

    .competition-img {
        width: 40%;
        height: auto;
        object-fit: cover;
        align-self: stretch;
    }

    .competition-info {
        width: 60%;
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .competition-info h3 {
        color: #1a096e;
        font-size: 1.8rem;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .competition-date {
        background: #D08301;
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        display: inline-block;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .competition-location {
        color: #5d6d7e;
        margin-bottom: 15px;
        font-size: 1rem;
    }

    .competition-location i {
        color: #D08301;
        margin-right: 8px;
    }

    .competition-description {
        color: #5d6d7e;
        line-height: 1.6;
        margin-bottom: 20px;
        font-size: 1rem;
        flex-grow: 1;
    }

    .btn-competition {
        background: #D08301;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 25px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        font-weight: 600;
        align-self: flex-start;
    }

    .btn-competition:hover {
        background: #b36f00;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(210, 131, 1, 0.4);
    }

    .competition-reverse .competition-content {
        flex-direction: row-reverse;
    }

    @media (max-width: 768px) {
        .competition-content {
            flex-direction: column;
            min-height: auto;
        }

        .competition-img,
        .competition-info {
            width: 100%;
        }

        .competition-img {
            height: 200px;
        }

        .competition-info {
            padding: 20px;
        }
    }
</style>

<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Competitions</h1>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Hero Video Card Start -->
<div class="container mt-5 position-relative">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden wow fadeInUp" data-wow-delay="0.2s">
        <video class="w-100" autoplay muted loop controls style="max-height: 550px; object-fit: cover;">
            <source src="{{ $videoUrl }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</div>
<!-- Hero Video Card End -->

<!-- Competitions Content -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Student Activities</h6>
            <h1 class="mb-5" style="color: #1a096e;">University Competitions</h1>
        </div>

        @if($competitions->count() > 0)
            @foreach($competitions as $index => $competition)
                <!-- Competition {{ $index + 1 }} -->
                <div class="competition-card {{ $index % 2 == 1 ? 'competition-reverse' : '' }} wow fadeInUp" data-wow-delay="{{ 0.1 + ($index * 0.1) }}s">
                    <div class="competition-content">
                        @if($competition->image)
                            <img src="{{ asset($competition->image) }}" class="competition-img" alt="{{ $competition->title }}">
                        @else
                            <div class="competition-img bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-trophy text-gray-400" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        <div class="competition-info">
                            <span class="competition-date">{{ $competition->date }}</span>
                            <h3>{{ $competition->title }}</h3>
                            <p class="competition-description">
                                {!! nl2br(e($competition->description)) !!}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <i class="fas fa-trophy text-gray-400" style="font-size: 5rem;"></i>
                <h3 class="mt-4" style="color: #1a096e;">No Competitions Yet</h3>
                <p class="text-gray-600">Competition information will be displayed here once added.</p>
            </div>
        @endif
    </div>
</div>
@endsection
