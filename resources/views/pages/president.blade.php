@extends('layouts.app')

@section('title', 'University President - New Cairo University of Technology')

@push('styles')
<style>
    :root {
        --blue: #1a096e;
        --gold: #D08301;
    }

    .president-section {
        background: #f4f7fc;
        padding: 60px 0;
    }

    .president-section .container {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: center;
    }

    .president-card {
        background: #fff;
        border-radius: 20px;
        border-left: 6px solid var(--gold);
        padding: 40px;
        max-width: 960px;
        width: 100%;
        box-shadow: 0 8px 32px rgba(24,29,56,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .president-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 48px rgba(24,29,56,0.16);
    }

    .president-card--main {
        display: flex;
        flex-direction: row;
        gap: 40px;
        align-items: flex-start;
    }

    .president-card--main .president-img-col {
        flex: 0 0 auto;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .president-card--main .president-img-col img {
        width: 240px;
        height: 290px;
        object-fit: cover;
        border-radius: 16px;
        border: 4px solid var(--gold);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        display: block;
    }

    .president-card--main .president-text-col { flex: 1 1 0; }

    .president-card--main h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--blue);
        margin-bottom: 6px;
    }

    .president-card--main h6 {
        font-style: italic;
        color: var(--gold);
        margin-bottom: 20px;
    }

    .president-card--main p {
        font-size: 1rem;
        line-height: 1.85;
        color: #444;
    }

    .president-card--secondary h4 {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--blue);
        border-left: 4px solid var(--gold);
        padding-left: 12px;
        margin-bottom: 18px;
    }

    .president-card--secondary p {
        font-size: 0.95rem;
        line-height: 1.8;
        color: #444;
    }

    .president-card strong { color: var(--gold); }

    @media (max-width: 767px) {
        .president-section { padding: 40px 16px; }
        .president-card { padding: 28px 24px; }
        .president-card--main { flex-direction: column; align-items: center; }
        .president-card--main .president-img-col img { width: 180px; height: 220px; }
        .president-card--main .president-text-col { width: 100%; }
    }
</style>
@endpush

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">NCTU President</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">President</li>
            </ol>
        </nav>
    </div>
</div>

<section class="president-section">
<div class="container">

    <div class="president-card president-card--main wow fadeInUp" data-wow-delay="0.1s">
        <div class="president-img-col">
            @if($president && $president->image)
                <img src="{{ asset($president->image) }}" alt="President">
            @else
                <img src="{{ asset('img/present.png') }}" alt="President">
            @endif
        </div>
        <div class="president-text-col">
            <h3>
                @if($president && $president->full_name)
                    {{ $president->full_name }}
                @else
                    Professor Dr. Tarek Abdelmalak
                @endif
            </h3>
            <h6><i>
                @if($president && $president->position)
                    {{ $president->position }}
                @else
                    President of New Cairo Technological University
                @endif
            </i></h6>
            <p>
                @if($president && $president->welcome_text)
                    {!! nl2br(e($president->welcome_text)) !!}
                @else
                    On behalf of all faculty members and their assistants at <strong>New Cairo Technological University (NCT)</strong>, I warmly welcome you as new members of our university family. We believe that true success is not limited to academics but also includes building character, developing skills, and broadening horizons.
                @endif
            </p>
        </div>
    </div>

    <div class="president-card president-card--secondary wow fadeInUp" data-wow-delay="0.1s">
        <h4>Education</h4>
        @if($president && $president->education)
            {!! nl2br(e($president->education)) !!}
        @else
            <p><strong>PhD (Mechanical Power Engineering)</strong>, Shanghai University, China – 2002</p>
            <p><strong>Master's Degree (Mechanical Power Engineering)</strong>, Cairo University, Egypt – 1996</p>
            <p><strong>Bachelor's Degree (Mechanical Power Engineering)</strong>, Menoufia University, Egypt – 1991</p>
        @endif
    </div>

    <div class="president-card president-card--secondary wow fadeInUp" data-wow-delay="0.1s">
        <h4>Postdoctoral Missions</h4>
        @if($president && $president->postdoctoral)
            {!! nl2br(e($president->postdoctoral)) !!}
        @else
            <p>2003-2005: Scientific mission at KAIST, South Korea</p>
            <p>2017: Short research visit at Kumamoto University, Japan</p>
        @endif
    </div>

    <div class="president-card president-card--secondary wow fadeInUp" data-wow-delay="0.1s">
        <h4>Administrative History & Achievements</h4>
        @if($president && $president->administrative)
            {!! nl2br(e($president->administrative)) !!}
        @else
            <p><strong>Consultant</strong> at Niaf Paper Products Company (2005-2006)</p>
            <p><strong>Consultant</strong> at Ramen Paper Products Company (2008-2012)</p>
            <p><strong>Project Manager</strong> for Training Centers – Funded by Korean Government (2015-2017)</p>
            <p><strong>Member of the Advisory</strong> Committee at the Science and Technology Development Fund (STDF)</p>
            <p>Honored as one of the Top Ten Directors of Technological Education Centers in Africa by the African Union (2015)</p>
        @endif
    </div>

</div>
</section>
@endsection
