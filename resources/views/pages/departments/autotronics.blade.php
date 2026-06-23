@extends('layouts.app')

@section('title', 'Autotronics Technology - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown"><i class="fa fa-car me-3"></i>Autotronics Technology</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home Page</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/faculty-it') }}">Industry & Energy</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Autotronics</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        
        <!-- Department Overview -->
        <div class="row g-5 align-items-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-6">
                <img src="{{ asset('img/Departments/autotronics.jpg') }}" class="img-fluid rounded shadow" alt="Autotronics Department">
            </div>
            <div class="col-lg-6">
                <h6 class="section-title bg-white text-start text-primary pe-3">Department Overview</h6>
                <h1 class="mb-4">Autotronics Technology</h1>
                <p class="mb-4 lead">Revolutionizing the automotive industry through advanced electric vehicles, diagnostics, and electronic control units. Master the technology behind modern and future vehicles.</p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">Hybrid & EV Systems</h6>
                                <small>Electric Vehicle Technology</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">Diagnostics</h6>
                                <small>ECU & OBD Systems</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">Transmission Systems</h6>
                                <small>Automatic & Manual</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">Vehicle Safety</h6>
                                <small>ADAS & Security</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vision & Mission -->
        <div class="row g-4 mb-5">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-5">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-bullseye fa-3x text-primary me-3"></i>
                        <h3 class="mb-0">Our Mission</h3>
                    </div>
                    <p class="mb-0">Revolutionizing the automotive industry through advanced electric vehicles, diagnostics, and electronic control units. We prepare automotive specialists who understand both mechanical systems and cutting-edge electronic integration.</p>
                </div>
            </div>
        </div>

        <!-- Core Courses -->
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Academic Program</h6>
            <h1 class="mb-3">Key Core Courses & Curriculum Highlights</h1>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="bg-primary text-white p-4 rounded-top">
                    <h4 class="mb-0"><i class="fa fa-graduation-cap me-2"></i>Year 1-2 Foundation</h4>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item">Math 2 & Principle of Electricity</div>
                    <div class="list-group-item">Hydraulic Basics</div>
                    <div class="list-group-item">Automotive Engines 1</div>
                    <div class="list-group-item">Technical Reports Writing</div>
                    <div class="list-group-item">Brake Systems & Suspension/Steering</div>
                    <div class="list-group-item">Engine Maintenance & Repair</div>
                    <div class="list-group-item">Communication Skills & Entrepreneurship</div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="bg-success text-white p-4 rounded-top">
                    <h4 class="mb-0"><i class="fa fa-trophy me-2"></i>Year 3-4 Advanced</h4>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item">Vehicles Safety & Security</div>
                    <div class="list-group-item">Luxury Vehicles Technology</div>
                    <div class="list-group-item">Automatic Transmission Systems</div>
                    <div class="list-group-item">Air Conditioning & Vehicle Dynamics</div>
                    <div class="list-group-item">Planning and Management</div>
                    <div class="list-group-item">Integrated Automotive Systems</div>
                    <div class="list-group-item">Hybrid Vehicles Technology</div>
                </div>
            </div>
        </div>

        <!-- Career Paths -->
        <div class="text-center mb-4 wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="mb-5">Career Opportunities</h1>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <i class="fa fa-car fa-3x text-primary mb-3"></i>
                    <h5 class="mb-3">Autonomous & Hybrid Vehicle Specialist</h5>
                    <p class="mb-0">Work with cutting-edge EV and hybrid vehicle systems</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <i class="fa fa-wrench fa-3x text-primary mb-3"></i>
                    <h5 class="mb-3">Automotive Diagnostic Engineer</h5>
                    <p class="mb-0">Master ECU programming and vehicle diagnostics</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <i class="fa fa-cogs fa-3x text-primary mb-3"></i>
                    <h5 class="mb-3">Fleet Maintenance Manager</h5>
                    <p class="mb-0">Oversee automotive service operations</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-primary rounded p-5 text-center wow fadeInUp" data-wow-delay="0.1s">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4"><i class="fa fa-rocket me-2"></i>Ready to Start Your Career?</h2>
                    <p class="text-white-50 mb-4 fs-5">Join NCTU's Autotronics Department and lead the evolution of advanced electric and hybrid vehicle engineering.</p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="{{ url('/admissions') }}" class="btn btn-light btn-lg rounded-pill px-5 py-3">
                            <i class="fa fa-file-alt me-2"></i>Apply Now
                        </a>
                        <a href="{{ url('/faculties-requirements') }}" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3">
                            <i class="fa fa-info-circle me-2"></i>Admission Requirements
                        </a>
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
