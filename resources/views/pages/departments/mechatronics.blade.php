@extends('layouts.app')

@section('title', 'Mechatronics Technology - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown"><i class="fa fa-robot me-3"></i>Mechatronics Technology</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Home Page</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="{{ route('facultyit') }}">Industry & Energy</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Mechatronics</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        
        <!-- Department Overview -->
        <div class="row g-5 align-items-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-6">
                <img src="{{ asset('img/Mecha.jpg') }}" class="img-fluid rounded shadow" alt="Mechatronics Department">
            </div>
            <div class="col-lg-6">
                <h6 class="section-title bg-white text-start text-primary pe-3">Department Overview</h6>
                <h1 class="mb-4">Mechatronics Technology</h1>
                <p class="mb-4 lead">Fusing mechanics, electronics, and smart automation to drive Industry 4.0. Our program prepares you to design, build, and maintain intelligent robotic systems and automated production lines.</p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">Robotics Engineering</h6>
                                <small>Design & Programming</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">PLC & SCADA</h6>
                                <small>Industrial Automation</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">CNC Technology</h6>
                                <small>Precision Manufacturing</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">Power Electronics</h6>
                                <small>Motor Control & Drives</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vision & Mission -->
        <div class="row g-4 mb-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-5 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-eye fa-3x text-primary me-3"></i>
                        <h3 class="mb-0">Our Vision</h3>
                    </div>
                    <p class="mb-0">To be a regional leader in mechatronics education, producing innovators who design intelligent automation systems that revolutionize manufacturing and industrial processes across the Middle East.</p>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="bg-light rounded p-5 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-bullseye fa-3x text-primary me-3"></i>
                        <h3 class="mb-0">Our Mission</h3>
                    </div>
                    <p class="mb-0">Fusing mechanics, electronics, and smart automation to drive Industry 4.0 transformation. We prepare graduates to engineer robotic solutions that enhance productivity, safety, and efficiency in modern industrial environments.</p>
                </div>
            </div>
        </div>

        <!-- Core Courses Curriculum -->
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Academic Program</h6>
            <h1 class="mb-3">Key Core Courses & Curriculum Highlights</h1>
            <p class="lead">4-Year Journey Through Mechatronics Excellence</p>
        </div>

        <!-- Year 1 -->
        <div class="mb-4 wow fadeInUp" data-wow-delay="0.2s">
            <div class="bg-primary text-white p-4 rounded">
                <h3 class="mb-0"><i class="fa fa-graduation-cap me-2"></i>Year 1 - Foundation</h3>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item"><i class="fa fa-cogs text-primary me-2"></i>Computer Aided Kinematics</div>
                <div class="list-group-item"><i class="fa fa-language text-primary me-2"></i>Technical English at Work Place II</div>
                <div class="list-group-item"><i class="fa fa-bolt text-primary me-2"></i>Electric Circuits</div>
                <div class="list-group-item"><i class="fa fa-laptop text-primary me-2"></i>Computer Technology</div>
                <div class="list-group-item"><i class="fa fa-leaf text-primary me-2"></i>Environmental Studies</div>
                <div class="list-group-item"><i class="fa fa-tools text-primary me-2"></i>Basic Mechatronics Workshop</div>
            </div>
        </div>

        <!-- Year 2 -->
        <div class="mb-4 wow fadeInUp" data-wow-delay="0.3s">
            <div class="bg-success text-white p-4 rounded">
                <h3 class="mb-0"><i class="fa fa-certificate me-2"></i>Year 2 - Core Systems</h3>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item"><i class="fa fa-wrench text-success me-2"></i>Electromechanical Systems Maintenance</div>
                <div class="list-group-item"><i class="fa fa-industry text-success me-2"></i>Manufacturing Technology</div>
                <div class="list-group-item"><i class="fa fa-robot text-success me-2"></i>Mechatronic Systems for Technologists</div>
                <div class="list-group-item"><i class="fa fa-briefcase text-success me-2"></i>Enterprise & Entrepreneurship I</div>
            </div>
        </div>

        <!-- Year 3 -->
        <div class="mb-4 wow fadeInUp" data-wow-delay="0.4s">
            <div class="bg-info text-white p-4 rounded">
                <h3 class="mb-0"><i class="fa fa-microchip me-2"></i>Year 3 - Advanced Technologies</h3>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item"><i class="fa fa-drafting-compass text-info me-2"></i>Mechanism Design for Technologists</div>
                <div class="list-group-item"><i class="fa fa-plug text-info me-2"></i>Power Electronics and Drives</div>
                <div class="list-group-item"><i class="fa fa-microchip text-info me-2"></i>Microprocessor Technology</div>
                <div class="list-group-item"><i class="fa fa-cog text-info me-2"></i>CNC Technology</div>
                <div class="list-group-item"><i class="fa fa-project-diagram text-info me-2"></i>Production System Planning and Control</div>
            </div>
        </div>

        <!-- Year 4 -->
        <div class="mb-5 wow fadeInUp" data-wow-delay="0.5s">
            <div class="bg-warning text-dark p-4 rounded">
                <h3 class="mb-0"><i class="fa fa-trophy me-2"></i>Year 4 - Automation & Enterprise</h3>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item"><i class="fa fa-sitemap text-warning me-2"></i>Advanced PLC Programming</div>
                <div class="list-group-item"><i class="fa fa-desktop text-warning me-2"></i>SCADA Systems</div>
                <div class="list-group-item"><i class="fa fa-rocket text-warning me-2"></i>Enterprise & Entrepreneurship II</div>
            </div>
        </div>

        <!-- Career Paths -->
        <div class="text-center mb-4 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Career Opportunities</h6>
            <h1 class="mb-5">Where Can You Work?</h1>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-robot text-primary"></i>
                    </div>
                    <h5 class="mb-3">Robotics Engineer</h5>
                    <p class="mb-0">Design and program intelligent robots for manufacturing and assembly lines</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-industry text-primary"></i>
                    </div>
                    <h5 class="mb-3">Automation Specialist</h5>
                    <p class="mb-0">Implement smart factory solutions using PLC and SCADA systems</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-code text-primary"></i>
                    </div>
                    <h5 class="mb-3">PLC Programmer</h5>
                    <p class="mb-0">Develop control systems for industrial machinery and processes</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="service-item bg-light rounded h-100 p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-tools text-primary"></i>
                    </div>
                    <h5 class="mb-3">Maintenance Manager</h5>
                    <p class="mb-0">Oversee industrial equipment maintenance and troubleshooting</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-primary rounded p-5 text-center wow fadeInUp" data-wow-delay="0.1s">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4"><i class="fa fa-rocket me-2"></i>Ready to Start Your Career?</h2>
                    <p class="text-white-50 mb-4 fs-5">Join NCTU's Mechatronics Department and master smart robotics and industrial automation ecosystems.</p>
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
