@extends('layouts.app')

@section('title', 'Prosthetics & Orthotics Technology - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown"><i class="fa fa-wheelchair me-3"></i>Prosthetics & Orthotics Technology</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Home Page</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="{{ route('facultyhealth') }}">Health Sciences</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Prosthetics</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">

        <div class="row g-5 align-items-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-6">
                <img src="{{ asset('img/Prosthetics.jpg') }}" class="img-fluid rounded shadow" alt="Prosthetics">
            </div>
            <div class="col-lg-6">
                <h1 class="mb-4">Prosthetics & Orthotics Technology</h1>
                <p class="lead">Advancing rehabilitative medical tech to engineer state-of-the-art bio-mechanical limbs and orthotic support infrastructure.</p>
            </div>
        </div>

        <div class="text-center mb-4 wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="mb-3">Core Studies & Advanced Senior Curriculum</h1>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="bg-primary text-white p-4 rounded-top"><h4 class="mb-0">Core Studies Highlight</h4></div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item">Orthotic Management for Orthopedic Conditions</div>
                    <div class="list-group-item">Comparative Culture</div>
                    <div class="list-group-item">Orthotic Management for Neurological Conditions</div>
                    <div class="list-group-item">English V</div>
                    <div class="list-group-item">Principles of Gait Analysis and Deviation (2)</div>
                    <div class="list-group-item">Hip, Knee & Ankle Disarticulation Prosthetics</div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="bg-success text-white p-4 rounded-top"><h4 class="mb-0">Advanced Senior Studies</h4></div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item">Biostatistics & Research</div>
                    <div class="list-group-item">Bionic Prosthetics & Orthotics</div>
                    <div class="list-group-item">Orthotic Management of Congenital Deformity</div>
                    <div class="list-group-item">Management of Diabetic Foot</div>
                    <div class="list-group-item">Clinical Management</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <i class="fa fa-robot fa-3x text-primary mb-3"></i>
                    <h5>Bionic Prosthetic Designer</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <i class="fa fa-user-md fa-3x text-primary mb-3"></i>
                    <h5>Clinical Orthotist Specialist</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <i class="fa fa-cogs fa-3x text-primary mb-3"></i>
                    <h5>Rehabilitative Product Engineer</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <i class="fa fa-walking fa-3x text-primary mb-3"></i>
                    <h5>Biomechanical Gait Analyst</h5>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-primary rounded p-5 text-center wow fadeInUp" data-wow-delay="0.1s">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4"><i class="fa fa-rocket me-2"></i>Ready to Start Your Career?</h2>
                    <p class="text-white-50 mb-4 fs-5">Join NCTU's Prosthetics & Orthotics Department and specialize in advanced bionic limbs and bio-mechanical rehabilitative tech.</p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="{{ url('/admissions') }}" class="btn btn-light btn-lg rounded-pill px-5 py-3">
                            <i class="fa fa-file-alt me-2"></i>Apply Now
                        </a>
                        {{-- <a href="{{ url('/faculties-requirements') }}" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3">
                            <i class="fa fa-info-circle me-2"></i>Admission Requirements
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Resources -->
        <div class="row g-4 mt-5">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card border-0 shadow h-100">
                    <div class="card-body text-center p-4">
                        <i class="fa fa-graduation-cap fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Faculties Requirements</h5>
                        <p class="card-text">Review academic requirements and admission criteria for our undergraduate programs.</p>
                        <a href="{{ url('/faculties-requirements') }}" class="btn btn-outline-primary rounded-pill">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="card border-0 shadow h-100">
                    <div class="card-body text-center p-4">
                        <i class="fa fa-chalkboard-teacher fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Training Programs</h5>
                        <p class="card-text">Explore workshops, internships, and dynamic industry field training opportunities.</p>
                        <a href="{{ url('/trainings') }}" class="btn btn-outline-primary rounded-pill">View Training</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="card border-0 shadow h-100">
                    <div class="card-body text-center p-4">
                        <i class="fa fa-phone-alt fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Contact Us</h5>
                        <p class="card-text">Have specific enrollment questions? Reach out directly to our admissions office.</p>
                        <a href="{{ url('/contact') }}" class="btn btn-outline-primary rounded-pill">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
