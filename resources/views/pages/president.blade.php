@extends('layouts.app')

@section('title', 'University President - New Cairo University of Technology')

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
                <h1 class="display-3 text-white animated slideInDown"> NCTU President</h1>
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
        @if($president && $president->image)
            <img src="{{ asset($president->image) }}" alt="President">
        @else
            <img src="{{ asset('img/present.png') }}" alt="President">
        @endif
        <br>
        <h3>
            @if($president && $president->full_name)
                {{ $president->full_name }}
            @else
                Professor Dr. Tarek Abdelmalak
            @endif
        </h3>
        <h6> 
            <i> 
                @if($president && $president->position)
                    {{ $president->position }}
                @else
                    President of New Cairo Technological University
                @endif
            </i>
        </h6>
        <br>
        <p>
            @if($president && $president->welcome_text)
                {!! nl2br(e($president->welcome_text)) !!}
            @else
                On behalf of all faculty members and their assistants at <strong>New Cairo Technological University
                (NCT)</strong>, I warmly welcome you as new members of our university family.
                We believe that true success is not limited to academics but also includes building character,
                developing skills, and broadening horizons.
            @endif
        </p>
    </div>

    <!-- Education -->
    <div class="president-card">
        <h4>Education</h4>
        @if($president && $president->education)
            {!! nl2br(e($president->education)) !!}
        @else
            <p><strong>PhD (Mechanical Power Engineering)</strong>, Shanghai University, China – 2002</p>
            <p><strong>Master's Degree (Mechanical Power Engineering)</strong>, Cairo University, Egypt – 1996</p>
            <p><strong>Bachelor's Degree (Mechanical Power Engineering)</strong>, Menoufia University, Egypt – 1991</p>
        @endif
    </div>

    <!-- Postdoctoral -->
    <div class="president-card">
        <h4>Postdoctoral Missions</h4>
        @if($president && $president->postdoctoral)
            {!! nl2br(e($president->postdoctoral)) !!}
        @else
            <p>2003-2005: Scientific mission at KAIST, South Korea</p>
            <p>2017: Short research visit at Kumamoto University, Japan</p>
        @endif
    </div>

    <!-- Administrative -->
    <div class="president-card">
        <h4>Administrative History & Achievements</h4>
        @if($president && $president->administrative)
            {!! nl2br(e($president->administrative)) !!}
        @else
            <p><strong> Consultant </strong> at Niaf Paper Products Company (2005-2006)</p>
            <p><strong>Consultant </strong> at Ramen Paper Products Company (2008-2012)</p>
            <p><strong>Project Manager </strong> for Training Centers – Funded by Korean Government (2015-2017)</p>
            <p><strong>Member of the Advisory </strong>Committee at the Science and Technology Development Fund (STDF)</p>
            <p>Honored as one of the Top Ten Directors of Technological Education Centers in Africa by the African Union
                (2015)</p>
        @endif
    </div>
</section>
@endsection
