@extends('layouts.app')

@section('title', 'Postgraduate Programs - New Cairo University of Technology')

@section('content')
<style>
    body {
        background: #ffffff;
        color: #040faa;
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    .page-title {
        text-align: center;
        font-size: 3rem;
        font-weight: 700;
        color: #D08301;
        margin-top: 60px;
        letter-spacing: 1px;
    }

    .program-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        padding: 60px 10%;
    }

    .program-card {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #fff;
    }

    .program-card:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 30px rgba(64, 15, 170, 0.2);
    }

    .program-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(75%);
        transition: filter 0.3s ease;
    }

    .program-card:hover img {
        filter: brightness(90%);
    }

    .program-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: rgba(0, 0, 0, 0.45);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .program-card:hover .program-overlay {
        opacity: 1;
    }

    .program-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #D08301;
        text-shadow: 0 0 8px rgba(208, 131, 1, 0.5);
    }

    .explore-btn {
        margin-top: 15px;
        padding: 10px 25px;
        background: #D08301;
        border: none;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .explore-btn:hover {
        background: #040faa;
        color: #fff;
    }
</style>

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Postgraduate Programs</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Postgraduate</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Advanced Studies</h6>
            <h1 class="mb-5">Postgraduate Programs</h1>
        </div>

        <div class="program-grid">
            <a href="{{ route('energyPostgraduate') }}" class="program-card wow zoomIn" data-wow-delay="0.1s">
                <img src="{{ asset('img/MET.jpg') }}" alt="Energy Technology">
                <div class="program-overlay">
                    <h3 class="program-title">Renewable Energy</h3>
                    <button class="explore-btn">Read More</button>
                </div>
            </a>

            <a href="{{ route('mechatronicsPostgraduate') }}" class="program-card wow zoomIn" data-wow-delay="0.2s">
                <img src="{{ asset('img/MMT.jpg') }}" alt="Mechatronics">
                <div class="program-overlay">
                    <h3 class="program-title">Mechatronics</h3>
                    <button class="explore-btn">Read More</button>
                </div>
            </a>

            <a href="{{ route('itPostgraduate') }}" class="program-card wow zoomIn" data-wow-delay="0.3s">
                <img src="{{ asset('img/mit.jpg') }}" alt="Information Technology">
                <div class="program-overlay">
                    <h3 class="program-title">Information Technology</h3>
                    <button class="explore-btn">Read More</button>
                </div>
            </a>

            <a href="{{ route('petroleumPostgraduate') }}" class="program-card wow zoomIn" data-wow-delay="0.4s">
                <img src="{{ asset('img/MPT.jpg') }}" alt="Petroleum Technology">
                <div class="program-overlay">
                    <h3 class="program-title">Petroleum</h3>
                    <button class="explore-btn">Read More</button>
                </div>
            </a>

            <a href="{{ route('prostheticsPostgraduate') }}" class="program-card wow zoomIn" data-wow-delay="0.5s">
                <img src="{{ asset('img/MRT.jpg') }}" alt="Prosthetics & Orthotics Technology">
                <div class="program-overlay">
                    <h3 class="program-title">Prosthetics</h3>
                    <button class="explore-btn">Read More</button>
                </div>
            </a>

            <a href="{{ route('autotronicsPostgraduate') }}" class="program-card wow zoomIn" data-wow-delay="0.6s">
                <img src="{{ asset('img/MAT.jpg') }}" alt="Auto-truncation Technology">
                <div class="program-overlay">
                    <h3 class="program-title">Auto-truncation</h3>
                    <button class="explore-btn">Read More</button>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
