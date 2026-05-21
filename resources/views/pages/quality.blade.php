@extends('layouts.app')

@section('title', 'Quality Assurance Unit')

@section('content')
<style>
    :root {
        --blue: #1a096e;
        --gold: #D08301;
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
        margin: 0 auto;
    }

    .president-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    }
</style>

<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Quality Assurance</h1>
                <nav aria-label="breadcrumb">
                    <!-- Breadcrumb can be added here if needed -->
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Quality Links -->
<section class="president-section">
    <div class="president-card">
        <br>
        <div class="d-flex flex-wrap justify-content-start">
            <div class="col-6">
                @foreach($qualityPages->take(ceil($qualityPages->count() / 2)) as $page)
                    <a href="{{ route('quality.show', ['slug' => $page->slug]) }}" class="dropdown-item">{{ $page->title }}</a>
                @endforeach
            </div>
            <div class="col-6">
                @foreach($qualityPages->skip(ceil($qualityPages->count() / 2)) as $page)
                    <a href="{{ route('quality.show', ['slug' => $page->slug]) }}" class="dropdown-item">{{ $page->title }}</a>
                @endforeach
            </div>
        </div>
    </div>
    <br>
</section>
@endsection
