@extends('layouts.app')

@section('title', 'Renewable Energy Technology - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown"><i class="fa fa-sun me-3"></i>Renewable Energy Technology</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home Page</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/faculty-it') }}">Industry & Energy</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Renewable Energy</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        
        <div class="row g-5 align-items-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-6">
                <img src="{{ asset('img/Departments/renewable energy.jpg') }}" class="img-fluid rounded shadow" alt="Renewable Energy">
            </div>
            <div class="col-lg-6">
                <h1 class="mb-4">Renewable Energy Technology</h1>
                <p class="lead">Pioneering clean, green, and sustainable energy engineering solutions for global climate preservation.</p>
            </div>
        </div>

        <!-- Specialization Tracks -->
        <div class="alert alert-success mb-5 wow fadeInUp" data-wow-delay="0.2s">
            <h4 class="alert-heading"><i class="fa fa-road me-2"></i>Year 3 Specialization Tracks</h4>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fa fa-sun text-warning me-2"></i>Solar Energy Track</h6>
                    <p class="small">Solar Thermal Systems, PV Systems, Industrial Automation</p>
                </div>
                <div class="col-md-6">
                    <h6><i class="fa fa-wind text-primary me-2"></i>Wind Energy Track</h6>
                    <p class="small">Hybrid Systems, WT Systems Installation & Commissioning</p>
                </div>
            </div>
        </div>

        <div class="text-center mb-4 wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="mb-3">Key Core Courses</h1>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="bg-primary text-white p-4 rounded-top"><h4 class="mb-0">Year 1-2 Foundation</h4></div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item">Human Rights & Health and Safety</div>
                    <div class="list-group-item">English Language II & IV</div>
                    <div class="list-group-item">Further Mathematics</div>
                    <div class="list-group-item">Mechanical Principles</div>
                    <div class="list-group-item">Analog and Digital Electronics</div>
                    <div class="list-group-item">Workshop Practices</div>
                    <div class="list-group-item">Thermodynamics and Heat Transfer</div>
                    <div class="list-group-item">Instrumentation and Measurements</div>
                    <div class="list-group-item">Installation, Maintenance and Repair of Small RE Systems</div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="bg-success text-white p-4 rounded-top"><h4 class="mb-0">Year 3-4 Advanced</h4></div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item">Solar Thermal Systems</div>
                    <div class="list-group-item">On-grid/Off-grid PV and WT System Testing</div>
                    <div class="list-group-item">Transmission and Distribution</div>
                    <div class="list-group-item">Industrial Automation</div>
                    <div class="list-group-item">Power Electronics and Drives</div>
                    <div class="list-group-item">Energy and Building Management Systems</div>
                    <div class="list-group-item">Smart Grid Technology</div>
                    <div class="list-group-item">Power System Protection</div>
                    <div class="list-group-item">Energy Saving Applications</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <i class="fa fa-solar-panel fa-3x text-primary mb-3"></i>
                    <h5>Solar Grid Integrator</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <i class="fa fa-wind fa-3x text-primary mb-3"></i>
                    <h5>Wind Turbine Analyst</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <i class="fa fa-th fa-3x text-primary mb-3"></i>
                    <h5>Smart Grid Consultant</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <i class="fa fa-chart-line fa-3x text-primary mb-3"></i>
                    <h5>RE Site Manager</h5>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-primary rounded p-5 text-center wow fadeInUp" data-wow-delay="0.1s">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4"><i class="fa fa-rocket me-2"></i>Ready to Start Your Career?</h2>
                    <p class="text-white-50 mb-4 fs-5">Join NCTU's Renewable Energy Department and pioneer next-generation clean solar and wind technological solutions.</p>
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
