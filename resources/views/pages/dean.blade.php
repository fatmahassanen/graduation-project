@extends('layouts.app')

@section('title', ($dean->position ?? 'Dean') . ' - New Cairo University of Technology')

@section('content')
<style>
    :root {
        --blue: #1a096e;
        --gold: #D08301;
    }

    .president-section {
        padding: 60px 20px;
        display: flex;
        flex-direction: column;
        gap: 40px;
        align-items: center;
    }

    .president-card {
        background: #fff;
        border-left: 8px solid var(--gold);
        border-radius: 20px;
        padding: 30px 40px;
        max-width: 1000px;
        width: 100%;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        transition: all 0.4s ease;
        position: relative;
    }

    .president-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    }

    .president-card img {
        float: left;
        margin-right: 30px;
        border-radius: 15px;
        border: 4px solid var(--gold);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .president-card h3,
    .president-card h4 {
        font-family: 'Playfair Display', serif;
        color: var(--blue);
        font-weight: 900;
        margin-bottom: 12px;
    }

    .president-card p {
        font-size: 1.05rem;
        color: #333;
        line-height: 1.8;
    }

    .president-card strong {
        color: var(--gold);
    }

    @media(max-width: 992px) {
        .president-card img {
            float: none;
            display: block;
            margin: 0 auto 20px auto;
        }
    }
</style>

<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">
                    {{ $dean->faculty ?? $dean->position ?? 'Dean' }}
                </h1>
                <nav aria-label="breadcrumb">
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Dean Section -->
<section class="president-section">
    <!-- Main Dean Card -->
    <div class="president-card">
        @if($dean->image)
            <img src="{{ asset($dean->image) }}" alt="Dean">
        @else
            <img src="{{ asset('img/Dean' . $dean->order . '.png') }}" alt="Dean">
        @endif
        <br>
        <h3>{{ $dean->full_name ?? 'Dean Name' }}</h3>
        <h6> <i>{{ $dean->position ?? 'Dean Position' }}</i></h6>
        <br>
        <p>
            @if($dean->welcome_text)
                {!! nl2br(e($dean->welcome_text)) !!}
            @else
                Welcome message not available.
            @endif
        </p>
    </div>

    <!-- Education -->
    @if($dean->education)
        <div class="president-card">
            <h4>Education</h4>
            {!! nl2br(e($dean->education)) !!}
        </div>
    @endif

    <!-- Professional Experience -->
    @if($dean->experience)
        <div class="president-card">
            <h4>Professional Experience & Positions</h4>
            {!! nl2br(e($dean->experience)) !!}
        </div>
    @endif
</section>
@endsection
