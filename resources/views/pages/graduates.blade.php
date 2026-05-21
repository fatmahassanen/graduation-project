@extends('layouts.app')

@section('title', 'Graduate Certificates - New Cairo University of Technology')

@section('content')
<style>
    .full-image-container {
        position: relative;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }

    .full-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        filter: brightness(75%);
    }

    .image-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
    }

    .image-overlay h2 {
        font-size: 48px;
        margin-bottom: 15px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
    }

    .image-overlay p {
        font-size: 24px;
        text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.7);
    }

    @media (max-width: 768px) {
        .image-overlay h2 {
            font-size: 32px;
        }

        .image-overlay p {
            font-size: 18px;
        }
    }

    .multi-section {
        padding: 60px 10%;
        font-family: 'Segoe UI', sans-serif;
    }

    .item-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        flex-wrap: wrap;
        margin-bottom: 60px;
    }

    .image-box {
        flex: 1;
        max-width: 45%;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.4s ease;
    }

    .image-box img {
        width: 100%;
        height: auto;
        border-radius: 15px;
        transition: transform 0.5s ease;
    }

    .image-box:hover img {
        transform: scale(1.1);
    }

    .text-box {
        flex: 1;
        max-width: 50%;
        color: #003366;
    }

    .left-img .text-box {
        text-align: right;
    }

    .right-img .text-box {
        text-align: left;
    }

    .text-box h2 {
        font-size: 28px;
        margin-bottom: 15px;
        color: #002244;
    }

    .text-box p {
        font-size: 18px;
        line-height: 1.7;
        text-align: justify;
        text-justify: inter-word;
    }

    @media (max-width: 768px) {
        .item-container {
            flex-direction: column;
            text-align: center;
        }

        .right-img,
        .left-img {
            flex-direction: column;
        }

        .text-box {
            max-width: 100% !important;
            text-align: center !important;
        }

        .image-box {
            max-width: 100%;
        }
    }
</style>

<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Graduate Certificates</h1>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<div class="full-image-container">
    <img src="{{ $heroImage }}" alt="Full Width Image">
</div>

<section class="question-section">
    <div class="title-box">
        {{ $heroTitle }}
    </div>
</section>

<section class="multi-section">
    @foreach($graduates as $index => $graduate)
        @if($index % 2 == 0)
            <!-- Left Image Layout -->
            <div class="item-container left-img">
                <div class="image-box">
                    @if($graduate->image)
                        <img src="{{ asset($graduate->image) }}" alt="{{ $graduate->title }}">
                    @else
                        <img src="{{ asset('img/default-graduate.png') }}" alt="{{ $graduate->title }}">
                    @endif
                </div>
                <div class="text-box">
                    <h2>{{ $graduate->title }}</h2>
                    <p>{{ $graduate->description }}</p>
                </div>
            </div>
        @else
            <!-- Right Image Layout -->
            <div class="item-container right-img">
                <div class="text-box">
                    <h2>{{ $graduate->title }}</h2>
                    <p>{{ $graduate->description }}</p>
                </div>
                <div class="image-box">
                    @if($graduate->image)
                        <img src="{{ asset($graduate->image) }}" alt="{{ $graduate->title }}">
                    @else
                        <img src="{{ asset('img/default-graduate.png') }}" alt="{{ $graduate->title }}">
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</section>
@endsection
