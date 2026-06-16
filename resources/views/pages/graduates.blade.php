@extends('layouts.app')

@section('title', 'Graduate Achievements - New Cairo University of Technology')

@section('content')
<x-page-header :title="__('messages.graduate_achievements')" />

<div class="row g-5 align-items-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="col-lg-12 text-center">
        <h6 class="section-title bg-white text-center text-primary px-3">{{ $heroTitle }}</h6>
    </div>
</div>

<style>
    .multi-section {
        padding: 60px 10%;
        font-family: 'Segoe UI', sans-serif;
        background: #f8f9fa;
    }

    .item-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        flex-wrap: wrap;
        margin-bottom: 60px;
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
        height: 350px;
        object-fit: cover;
        border-radius: 15px;
        transition: transform 0.5s ease;
        display: block;
    }

    .image-box:hover img {
        transform: scale(1.08);
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
        margin-bottom: 18px;
        color: #1a096e;
        font-weight: 700;
    }

    .text-box p {
        font-size: 17px;
        line-height: 1.8;
        color: #4a5568;
        text-align: justify;
        text-justify: inter-word;
    }

    @media (max-width: 768px) {
        .item-container {
            flex-direction: column;
            text-align: center;
            padding: 20px;
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

        .image-box img {
            height: 250px;
        }
    }
</style>

<section class="multi-section">
    @forelse($graduates as $index => $graduate)
        @if($index % 2 == 0)
            <div class="item-container left-img">
                <div class="image-box">
                    @if($graduate->image)
                        <img src="{{ asset($graduate->image) }}" alt="{{ $graduate->title }}" loading="lazy">
                    @else
                        <img src="{{ asset('img/default-graduate.png') }}" alt="{{ $graduate->title }}" loading="lazy">
                    @endif
                </div>
                <div class="text-box">
                    <h2>{{ $graduate->title }}</h2>
                    <p>{{ $graduate->description }}</p>
                </div>
            </div>
        @else
            <div class="item-container right-img">
                <div class="text-box">
                    <h2>{{ $graduate->title }}</h2>
                    <p>{{ $graduate->description }}</p>
                </div>
                <div class="image-box">
                    @if($graduate->image)
                        <img src="{{ asset($graduate->image) }}" alt="{{ $graduate->title }}" loading="lazy">
                    @else
                        <img src="{{ asset('img/default-graduate.png') }}" alt="{{ $graduate->title }}" loading="lazy">
                    @endif
                </div>
            </div>
        @endif
    @empty
        <div class="text-center py-5">
            <p class="text-gray-500 text-lg">No graduate achievements available at the moment.</p>
        </div>
    @endforelse
</section>
@endsection
