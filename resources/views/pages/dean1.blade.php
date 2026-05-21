@extends('layouts.app')

@section('title', 'Dean of Industrial and Energy Technology - New Cairo University of Technology')

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
                <h1 class="display-3 text-white animated slideInDown">Dean of Industrial and Energy Technology Faculty</h1>
                <nav aria-label="breadcrumb">
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- President Section -->
<section class="president-section">
    <!-- Main President Card -->
    <div class="president-card">
        <img src="{{ asset('img/Dean1.png') }}" alt="Dean">
        <br>
        <h3>Professor Dr. Walid Al-Khatam</h3>
        <h6> <i>Dean of the College of Industrial Technology and Energy</i></h6>
        <br>
        <p>
            We are pleased to welcome you to the Faculty of Industrial and Energy Technology, where we believe that education is the foundation for building a better future. 
            Our faculty is committed to preparing highly qualified graduates who combine strong academic knowledge with practical skills that meet the needs of the labor market. 
            We strive to provide a modern and inspiring learning environment that encourages creativity and innovation. 
            We look forward to seeing our students become active partners in success and continuous development.
        </p>
    </div>

    <!-- Education -->
    <div class="president-card">
        <h4>Education</h4>
        <p><strong>Ph.D. in Electrical Engineering</strong>, University of Waterloo, Canada – June 2005</p>
        <p><strong>Master's Degree in Electrical Engineering (Power and Electrical Machines)</strong>, Ain Shams University, Egypt – 1996</p>
        <p><strong>Bachelor's Degree in Electrical Engineering (Power and Electrical Machines)</strong>, Ain Shams University, Egypt – 1996</p>
    </div>

    <!-- Administrative -->
    <div class="president-card">
        <h4>Professional Experience & Positions</h4>
        <p><strong>Professor</strong>, Department of Electrical Power and Machines Engineering, Faculty of Engineering, Ain Shams University, Egypt.</p>
        <p><strong>Consultant </strong> for Electricity and Renewable Energy Development Programs in Egypt and Arab countries (since 2014).</p>
        <p><strong> Technical Consultant, </strong> Energy Excellence Center, Faculty of Engineering, Ain Shams University (2021-2023)</p>
        <p><strong> Vice Chairman,</strong>  IEEE Power Engineering Society (PES) – Egypt Chapter (2020 – 2022)</p>
        <p><strong> Director,</strong>  Energy Excellence Center, Faculty of Engineering, Ain Shams University
            (2019 - 2021)</p>
    </div>
</section>
@endsection
