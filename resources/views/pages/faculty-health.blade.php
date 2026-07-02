@extends('layouts.app')

@section('title', 'Applied Health Sciences - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Applied Health Science Technology</h1>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">

        <div class="row g-5 align-items-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-12 text-center">
                <h6 class="section-title bg-white text-center text-success px-3">College Overview</h6>
                <h1 class="mb-4">Healthcare Reimagined</h1>
                <p class="mb-4 fs-5">The Faculty of Applied Health Sciences at NCTU is a unique medical-tech hub. We focus on graduating "Health Technologists" who master the high-tech equipment used in modern hospitals. Our students are the vital link between medicine and engineering, ensuring patient care is precise, digital, and efficient.</p>
            </div>
        </div>

        <div class="row g-4 mb-5 justify-content-center text-center">
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="p-4 shadow-sm border rounded bg-white h-100 border-top border-5 border-success">
                    <i class="fa fa-heartbeat fa-3x text-success mb-3"></i>
                    <h3 class="text-success">Our Vision</h3>
                    <p>To lead the transformation of healthcare in Egypt through the integration of clinical excellence and cutting-edge health technology.</p>
                </div>
            </div>
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.3s">
                <div class="p-4 shadow-sm border rounded bg-white h-100 border-top border-5 border-success">
                    <i class="fa fa-notes-medical fa-3x text-success mb-3"></i>
                    <h3 class="text-success">Our Mission</h3>
                    <p>Training competent, ethical health technologists who excel in medical diagnostics and prosthetic solutions to serve the community.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center text-center my-5 py-5 bg-light rounded wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-8">
                <h6 class="section-title bg-light text-center text-success px-3">Our Dean</h6>
                <h2 class="mb-4 text-dark">{{ $dean->full_name }}</h2>
                <p class="fs-5">"{{ Str::limit(explode("\n", $dean->welcome_text)[0], 150) }}"</p>
                <a href="{{ route('dean2') }}" class="btn btn-success px-5 py-3 rounded-pill mt-3">Meet the Dean</a>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-10 wow fadeInUp">
                <div class="p-5 shadow rounded border-start border-5 border-success bg-white text-center">
                    <i class="fa fa-wheelchair fa-4x text-success mb-4"></i>
                    <h2 class="mb-3">Prosthetics & Orthotics Technology</h2>
                    <p class="fs-5"><strong>What is it?</strong> It is the science of designing and manufacturing artificial limbs and support braces. This department uses 3D Printing, Biomechanics, and specialized materials to help people regain their mobility.</p>
                    <p class="fs-5"><strong>Qualifies you for:</strong> This is a <strong>High-Demand</strong> field. You will be a Specialist in Rehab Centers, Hospitals, or launch your own center for artificial limb manufacturing.</p>
                    <hr>
                    <p class="text-muted italic">"Ranked as one of the most stable and required healthcare careers in the 2026 job market."</p>
                    <a href="{{ url('/prosthetics') }}" class="btn btn-success btn-lg rounded-pill px-5 mt-3">View More</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
