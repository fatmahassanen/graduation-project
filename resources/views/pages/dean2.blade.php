@extends('layouts.app')

@section('title', 'Dean of Applied Health Sciences Technology - New Cairo University of Technology')

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
                <h1 class="display-3 text-white animated slideInDown">Dean of Applied Health Sciences Technology</h1>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- President Section -->
<section class="president-section">
    <div class="president-card">
        <img src="{{ asset('img/Dean2.png') }}" alt="Dean">
        <br>
        <h3>Professor Dr. Mohammed Fawzi Al-Sawda</h3>
        <h6> <i>Dean of the College of Applied Health Sciences</i></h6>
        <br>
        <p>
            We are delighted to welcome you to the Faculty of Applied Health Sciences Technology, 
            where we are dedicated to advancing education and training in the vital fields of health sciences. 
            Our faculty aims to prepare competent graduates who combine scientific knowledge with practical skills to serve the community and meet the needs of the healthcare sector. 
            We are committed to providing a supportive and innovative learning environment that promotes excellence, ethics, and continuous improvement.
        </p>
    </div>

    <div class="president-card">
        <h4>Education</h4>
        <p><strong>Under Construction</strong></p>
    </div>

    <div class="president-card">
        <h4>Professional Experience & Positions</h4>
        <p>Under Construction</p>
    </div>
</section>
@endsection
