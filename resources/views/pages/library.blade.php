@extends('layouts.app')

@section('title', 'University Library - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">University Library</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Library</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Intro Section --}}
<section class="py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                <span class="lib-badge">Knowledge Hub</span>
                <h2 class="lib-intro-heading">Providing a Creative Learning Environment</h2>
                <div class="lib-divider mb-4"></div>
                <p class="lib-intro-text mb-3">The New Cairo Technological University Library is a cornerstone of our academic community. We provide students, faculty, and researchers with access to a vast array of high-quality information resources, both in print and digital formats.</p>
                <p class="lib-intro-text mb-4">Our mission is to support the university's curriculum and research goals by providing professional information services and a modern environment conducive to study and innovation.</p>
                <div class="row gy-3 gx-4 mb-2">
                    <div class="col-sm-6">
                        <p class="mb-0 lib-feature-item">
                            <span class="lib-feature-icon"><i class="fa fa-check"></i></span>Quiet Study Areas
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0 lib-feature-item">
                            <span class="lib-feature-icon"><i class="fa fa-check"></i></span>Digital Catalog Access
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0 lib-feature-item">
                            <span class="lib-feature-icon"><i class="fa fa-check"></i></span>Research Assistance
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0 lib-feature-item">
                            <span class="lib-feature-icon"><i class="fa fa-check"></i></span>Borrowing Services
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                <img class="lib-intro-img img-fluid" src="{{ asset('img/library1.jpg') }}" alt="NCTU Library">
            </div>
        </div>
    </div>
</section>

{{-- Events Section --}}
<section class="py-5" style="background:#f4f7fc;">
    <div class="container">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <span class="lib-badge">Library Events</span>
            <h2 class="lib-events-heading">Latest News & Exhibitions</h2>
            <div class="lib-divider mx-auto"></div>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="lib-event-card h-100">
                    <img src="{{ asset('img/library3.jpg') }}" class="lib-event-img" alt="NCTU Exhibition">
                    <div class="lib-event-body">
                        <h5 class="lib-event-title">NCTU Hosts Exhibition in the Library</h5>
                        <p class="lib-event-text">
                            The University Library at NCTU organized a special exhibition highlighting its rich collection of books and academic resources. Held under the patronage of Prof. Dr. Tarek Abdel Malak, visitors explored subjects including science, technology, and social sciences. The event aimed to promote reading habits and research skills among students.
                        </p>
                    </div>
                    <div class="lib-event-footer">
                        <span class="lib-event-tag tag-blue">Exhibition</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="lib-event-card h-100">
                    <img src="{{ asset('img/library4.jpg') }}" class="lib-event-img" alt="NCTU Special Event">
                    <div class="lib-event-body">
                        <h5 class="lib-event-title">NCTU Hosts Special Library Event</h5>
                        <p class="lib-event-text">
                            On July 10, 2025, the library organized a special event featuring interactive book displays and workshops on information literacy. Staff guided students on effective digital catalog navigation and research strategies, emphasizing the library's central role in supporting learning and personal growth.
                        </p>
                    </div>
                    <div class="lib-event-footer">
                        <span class="lib-event-tag tag-gold">Workshop</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="lib-event-card h-100">
                    <img src="{{ asset('img/library2.jpg') }}" class="lib-event-img" alt="NCTU Festival">
                    <div class="lib-event-body">
                        <h5 class="lib-event-title">Annual Book and Reading Festival</h5>
                        <p class="lib-event-text">
                            Supervised by Prof. Dr. Walid Elkhatam, the festival featured journals and academic publications with storytelling sessions for students. With over 200 participants, guest authors shared insights on research strategies. The festival aimed to cultivate a culture of engagement with knowledge.
                        </p>
                    </div>
                    <div class="lib-event-footer">
                        <span class="lib-event-tag tag-green">Festival</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- EKB Section --}}
<section class="py-5" style="background:#f4f7fc;">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-7 wow fadeInLeft" data-wow-delay="0.1s">
                <h2 class="mb-3 fw-bold lib-ekb-heading">Egyptian Knowledge Bank (EKB)</h2>
                <p class="fs-5" style="color:#555;line-height:1.8;">The university provides full access to the Egyptian Knowledge Bank for all registered students and faculty members. It is one of the world's largest digital libraries, providing access to international research and academic papers.</p>
                <a href="https://www.ekb.eg" target="_blank" class="lib-ekb-btn mt-4 d-inline-flex align-items-center gap-2">
                    Access EKB Now <i class="fa fa-external-link-alt"></i>
                </a>
            </div>
            <div class="col-lg-5 text-center wow zoomIn" data-wow-delay="0.3s">
                <img src="{{ asset('img/EKB.png') }}" alt="EKB Logo" style="max-width:250px;">
            </div>
        </div>
    </div>
</section>

{{-- Opening Hours --}}
<section class="py-5">
    <div class="container">
        <div class="lib-hours-card text-center wow fadeInUp" data-wow-delay="0.1s">
            <h2 class="lib-hours-title mb-5">Library Opening Hours</h2>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-3">
                    <h5 class="lib-hours-day">Sunday - Wednesday</h5>
                    <p class="lib-hours-time mb-0">09:00 AM – 04:00 PM</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="lib-hours-day">Thursday</h5>
                    <p class="lib-hours-time mb-0">09:00 AM – 02:00 PM</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="lib-hours-day">Friday - Saturday</h5>
                    <p class="lib-hours-time mb-0 fw-bold">Closed</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .lib-badge {
        display: inline-block;
        color: #D08301;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 10px;
    }
    .lib-divider {
        width: 50px; height: 4px;
        background: #D08301;
        border-radius: 2px;
        margin-top: 14px;
    }
    .lib-intro-heading {
        font-weight: 800;
        color: #181d38;
        font-size: clamp(1.5rem,3vw,2rem);
        margin-bottom: 0;
    }
    .lib-intro-text { color: #555; line-height: 1.8; }
    .lib-feature-item {
        display: flex; align-items: center;
        gap: 12px; color: #333; font-size: 0.95rem;
    }
    .lib-feature-icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 28px; height: 28px; min-width: 28px;
        background: #1a3a6e; color: #fff;
        border-radius: 50%; font-size: 0.68rem;
    }
    .lib-intro-img {
        border-radius: 18px;
        box-shadow: 0 10px 40px rgba(24,29,56,0.14);
        display: block; width: 100%;
    }
    .lib-events-heading {
        font-weight: 800; color: #181d38;
        font-size: clamp(1.6rem,3vw,2.2rem);
        margin-bottom: 14px;
    }
    /* Event cards */
    .lib-event-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(24,29,56,0.07);
        border-bottom: 4px solid #D08301;
        display: flex; flex-direction: column;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .lib-event-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 40px rgba(24,29,56,0.14);
    }
    .lib-event-img { height: 210px; object-fit: cover; display: block; width: 100%; }
    .lib-event-body { padding: 22px 22px 12px; flex: 1; }
    .lib-event-title { font-weight: 700; color: #181d38; font-size: 1rem; margin-bottom: 10px; line-height: 1.4; }
    .lib-event-text { color: #555; font-size: 0.875rem; line-height: 1.72; text-align: justify; margin: 0; }
    .lib-event-footer { padding: 12px 22px 20px; }
    .lib-event-tag {
        display: inline-block;
        padding: 4px 14px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700;
    }
    .tag-blue  { background:#1a3a6e;color:#fff; }
    .tag-gold  { background:#D08301;color:#fff; }
    .tag-green { background:#198754;color:#fff; }
    /* EKB */
    .lib-ekb-heading { color: #1a3a6e; }
    .lib-ekb-btn {
        background: linear-gradient(135deg,#1a3a6e,#2356c7);
        color: #fff; text-decoration: none;
        padding: 12px 28px; border-radius: 50px;
        font-weight: 700; font-size: 0.95rem;
        transition: transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 4px 16px rgba(26,58,110,0.25);
    }
    .lib-ekb-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(26,58,110,0.35);
        color: #fff;
    }
    /* Opening hours */
    .lib-hours-card {
        background: linear-gradient(135deg,#1a3a6e,#2356c7);
        border-radius: 20px;
        padding: 50px 40px;
        box-shadow: 0 8px 32px rgba(26,58,110,0.25);
    }
    .lib-hours-title { color: #fff; font-weight: 800; font-size: 1.8rem; }
    .lib-hours-day  { color: #D08301; font-weight: 700; font-size: 1.05rem; margin-bottom: 6px; }
    .lib-hours-time { color: #fff; font-size: 1rem; }
</style>
@endpush
