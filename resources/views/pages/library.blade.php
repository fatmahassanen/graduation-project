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
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center mb-5">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Knowledge Hub</h6>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="mb-4">Providing a Creative Learning Environment</h1>
                <p class="mb-4">The New Cairo Technological University Library is a cornerstone of our academic community. We provide students, faculty, and researchers with access to a vast array of high-quality information resources, both in print and digital formats.</p>
                <p class="mb-4">Our mission is to support the university's curriculum and research goals by providing professional information services and a modern environment conducive to study and innovation.</p>
                <div class="row gy-2 gx-4 mb-4">
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Quiet Study Areas</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Digital Catalog Access</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Research Assistance</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Borrowing Services</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <img class="img-fluid rounded-3 shadow" src="{{ asset('img/library1.jpg') }}" alt="NCTU Library">
            </div>
        </div>

        <div class="text-center wow fadeInUp mt-5" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Library Events</h6>
            <h1 class="mb-5">Latest News & Exhibitions</h1>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden event-card">
                    <img src="{{ asset('img/library3.jpg') }}" class="card-img-top" alt="NCTU Exhibition" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-primary">NCTU Hosts Exhibition in the Library</h5>
                        <p class="card-text small text-muted" style="line-height: 1.6; text-align: justify;">
                            The University Library at NCTU organized a special exhibition highlighting its rich collection of books and academic resources. Held under the patronage of Prof. Dr. Tarek Abdel Malak, visitors explored subjects including science, technology, and social sciences. The event aimed to promote reading habits and research skills among students.
                        </p>
                    </div>
                    <div class="card-footer bg-white border-0 pb-4 px-4">
                        <span class="badge bg-primary rounded-pill px-3">Exhibition</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden event-card">
                    <img src="{{ asset('img/library4.jpg') }}" class="card-img-top" alt="NCTU Special Event" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-primary">NCTU Hosts Special Library Event</h5>
                        <p class="card-text small text-muted" style="line-height: 1.6; text-align: justify;">
                            On July 10, 2025, the library organized a special event featuring interactive book displays and workshops on information literacy. Staff guided students on effective digital catalog navigation and research strategies, emphasizing the library's central role in supporting learning and personal growth.
                        </p>
                    </div>
                    <div class="card-footer bg-white border-0 pb-4 px-4">
                        <span class="badge bg-warning text-dark rounded-pill px-3">Workshop</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden event-card">
                    <img src="{{ asset('img/library2.jpg') }}" class="card-img-top" alt="NCTU Festival" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-primary">Annual Book and Reading Festival</h5>
                        <p class="card-text small text-muted" style="line-height: 1.6; text-align: justify;">
                            Supervised by Prof. Dr. Walid Elkhatam, the festival featured journals and academic publications with storytelling sessions for students. With over 200 participants, guest authors shared insights on research strategies. The festival aimed to cultivate a culture of engagement with knowledge.
                        </p>
                    </div>
                    <div class="card-footer bg-white border-0 pb-4 px-4">
                        <span class="badge bg-success rounded-pill px-3">Festival</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-5" style="background: #f8f9fc;">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.1s">
                <h2 class="mb-3 fw-bold" style="color: #1a096e;">Egyptian Knowledge Bank (EKB)</h2>
                <p class="fs-5">The university provides full access to the Egyptian Knowledge Bank for all registered students and faculty members. It is one of the world's largest digital libraries, providing access to international research and academic papers.</p>
                <a href="https://www.ekb.eg" target="_blank" class="btn btn-primary rounded-pill py-3 px-5 mt-3 shadow-sm">Access EKB Now <i class="fa fa-external-link-alt ms-2"></i></a>
            </div>
            <div class="col-lg-5 text-center wow zoomIn" data-wow-delay="0.3s">
                <img src="{{ asset('img/EKB.png') }}" alt="EKB Logo" style="max-width: 250px;">
            </div>
        </div>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="bg-primary rounded-3 p-5 text-center text-white wow fadeInUp" data-wow-delay="0.1s">
            <h2 class="text-white mb-4">Library Opening Hours</h2>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-3">
                    <h5 class="text-warning">Sunday - Wednesday</h5>
                    <p class="mb-0">09:00 AM - 04:00 PM</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="text-warning">Thursday</h5>
                    <p class="mb-0">09:00 AM - 02:00 PM</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="text-warning">Friday - Saturday</h5>
                    <p class="mb-0 fw-bold">Closed</p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('styles')
<style>
    .event-card {
        transition: all 0.3s ease;
        border-bottom: 5px solid #D08301 !important;
    }
    .event-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
    }
</style>
@endpush


