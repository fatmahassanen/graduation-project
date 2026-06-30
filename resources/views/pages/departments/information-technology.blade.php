@extends('layouts.app')

@section('title', 'Information Technology (ICT) Department - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Information Technology Department</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Home Page</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="{{ route('facultyit') }}">Industry & Energy</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">ICT</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">

        <!-- Department Overview -->
        <div class="row g-5 align-items-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-6">
                <img src="{{ asset('img/ICT.jpg') }}" class="img-fluid rounded shadow" alt="ICT Department">
            </div>
            <div class="col-lg-6">
                <h6 class="section-title bg-white text-start text-primary pe-3">Department Overview</h6>
                <h1 class="mb-4">Information & Communication Technology</h1>
                <p class="mb-4">The ICT Department at NCTU equips students with cutting-edge skills in computing, networking, and software development. Our curriculum combines theoretical knowledge with hands-on practical training to prepare graduates for the evolving tech industry.</p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">Backend Development</h6>
                                <small>PHP & Laravel Framework</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">Network Engineering</h6>
                                <small>Cisco CCNA Certified</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">Cybersecurity</h6>
                                <small>Network Security & Encryption</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">Database Management</h6>
                                <small>SQL & NoSQL Systems</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Career Paths -->
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Career Opportunities</h6>
            <h1 class="mb-5">Where Can You Work?</h1>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light rounded h-100 p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-code text-primary"></i>
                    </div>
                    <h4 class="mb-3">Backend Developer</h4>
                    <p class="mb-4">Build robust server-side applications using PHP, Laravel, and modern frameworks. Work with APIs, databases, and cloud services.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item bg-light rounded h-100 p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-network-wired text-primary"></i>
                    </div>
                    <h4 class="mb-3">Network Engineer</h4>
                    <p class="mb-4">Design, implement, and maintain enterprise network infrastructure. Cisco-certified pathways to global opportunities.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item bg-light rounded h-100 p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-shield-alt text-primary"></i>
                    </div>
                    <h4 class="mb-3">Security Specialist</h4>
                    <p class="mb-4">Protect digital assets through cybersecurity practices, penetration testing, and security architecture design.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light rounded h-100 p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-database text-primary"></i>
                    </div>
                    <h4 class="mb-3">Database Administrator</h4>
                    <p class="mb-4">Manage, optimize, and secure organizational databases. Handle data integrity, backup, and recovery systems.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item bg-light rounded h-100 p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-cloud text-primary"></i>
                    </div>
                    <h4 class="mb-3">Cloud Solutions Architect</h4>
                    <p class="mb-4">Design and deploy cloud infrastructure on AWS, Azure, or Google Cloud. Handle scalability and performance optimization.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item bg-light rounded h-100 p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-laptop text-primary"></i>
                    </div>
                    <h4 class="mb-3">IT Consultant</h4>
                    <p class="mb-4">Advise businesses on technology strategies, digital transformation, and IT infrastructure modernization.</p>
                </div>
            </div>
        </div>

        <!-- 4-Year Curriculum Plan -->
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Academic Program</h6>
            <h1 class="mb-3">4-Year Curriculum Breakdown</h1>
            <p class="lead">Complete your Higher Technological Diploma (Years 1-2) and Professional Bachelor's Degree (Years 3-4)</p>
        </div>

        <!-- Year 1: Freshman Foundation -->
        <div class="mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="bg-primary text-white p-4 rounded-top">
                <div class="d-flex align-items-center">
                    <i class="fa fa-graduation-cap fa-3x me-3"></i>
                    <div>
                        <h2 class="mb-0">Year 1 - Foundation Level</h2>
                        <p class="mb-0">Building Core Computing & Engineering Fundamentals</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60%">Course Name</th>
                            <th width="20%" class="text-center">Credit Hours (CH)</th>
                            <th width="20%" class="text-center">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Mathematics for Computing</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-secondary">Theoretical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Physics for Engineers</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-secondary">Theoretical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-laptop-code text-success me-2"></i>Introduction to Programming (C++)</td>
                            <td class="text-center"><span class="badge bg-info">5 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-laptop-code text-success me-2"></i>Digital Logic Design</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Technical English I</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-secondary">Theoretical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Engineering Drawing & CAD</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-laptop-code text-success me-2"></i>Computer Architecture & Organization</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Human Rights & Professional Ethics</td>
                            <td class="text-center"><span class="badge bg-info">2 CH</span></td>
                            <td class="text-center"><span class="badge bg-secondary">Theoretical</span></td>
                        </tr>
                        <tr class="table-primary">
                            <td class="fw-bold"><i class="fa fa-calculator me-2"></i>Year 1 Total</td>
                            <td class="text-center fw-bold"><span class="badge bg-primary fs-6">29 CH</span></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Year 2: Diploma Level -->
        <div class="mb-5 wow fadeInUp" data-wow-delay="0.2s">
            <div class="bg-success text-white p-4 rounded-top">
                <div class="d-flex align-items-center">
                    <i class="fa fa-certificate fa-3x me-3"></i>
                    <div>
                        <h2 class="mb-0">Year 2 - Higher Technological Diploma</h2>
                        <p class="mb-0">Advanced Programming, Databases & Network Fundamentals</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60%">Course Name</th>
                            <th width="20%" class="text-center">Credit Hours (CH)</th>
                            <th width="20%" class="text-center">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fa fa-laptop-code text-success me-2"></i>Object-Oriented Programming (Java)</td>
                            <td class="text-center"><span class="badge bg-info">5 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-laptop-code text-success me-2"></i>Data Structures & Algorithms</td>
                            <td class="text-center"><span class="badge bg-info">5 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-database text-success me-2"></i>Database Management Systems (SQL)</td>
                            <td class="text-center"><span class="badge bg-info">5 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-network-wired text-success me-2"></i>Computer Networks Fundamentals</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-laptop-code text-success me-2"></i>Web Development (HTML, CSS, JavaScript)</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Discrete Mathematics</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-secondary">Theoretical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Operating Systems</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Technical English II</td>
                            <td class="text-center"><span class="badge bg-info">2 CH</span></td>
                            <td class="text-center"><span class="badge bg-secondary">Theoretical</span></td>
                        </tr>
                        <tr class="table-success">
                            <td class="fw-bold"><i class="fa fa-calculator me-2"></i>Year 2 Total</td>
                            <td class="text-center fw-bold"><span class="badge bg-success fs-6">32 CH</span></td>
                            <td></td>
                        </tr>
                        <tr class="table-warning">
                            <td class="fw-bold"><i class="fa fa-trophy me-2"></i>Diploma Stage Total (Years 1-2)</td>
                            <td class="text-center fw-bold"><span class="badge bg-warning text-dark fs-6">61 CH</span></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Specialization Notice -->
        <div class="alert alert-info mb-5 wow fadeInUp" data-wow-delay="0.3s">
            <div class="d-flex align-items-center">
                <i class="fa fa-info-circle fa-3x me-3"></i>
                <div>
                    <h4 class="alert-heading mb-2"><i class="fa fa-road me-2"></i>Choose Your Specialization Track</h4>
                    <p class="mb-0">After completing your Higher Technological Diploma (Years 1-2), you will select one of two professional tracks for your Bachelor's degree:</p>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6><i class="fa fa-code text-primary me-2"></i>Track 1: Software Engineering</h6>
                            <p class="small mb-0">Focus on backend development, PHP/Laravel, APIs, and modern software architecture</p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fa fa-network-wired text-success me-2"></i>Track 2: Network Engineering</h6>
                            <p class="small mb-0">Focus on Cisco CCNA, network security, infrastructure design, and system administration</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Year 3: Software Engineering Track -->
        <div class="mb-5 wow fadeInUp" data-wow-delay="0.4s">
            <div class="bg-info text-white p-4 rounded-top">
                <div class="d-flex align-items-center">
                    <i class="fa fa-code fa-3x me-3"></i>
                    <div>
                        <h2 class="mb-0">Year 3 - Software Engineering Track</h2>
                        <p class="mb-0">Backend Development, Frameworks & Cloud Technologies</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60%">Course Name</th>
                            <th width="20%" class="text-center">Credit Hours (CH)</th>
                            <th width="20%" class="text-center">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fa fa-laptop-code text-success me-2"></i>Advanced PHP Programming</td>
                            <td class="text-center"><span class="badge bg-info">5 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-laptop-code text-success me-2"></i>Laravel Framework Development</td>
                            <td class="text-center"><span class="badge bg-info">5 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-server text-success me-2"></i>RESTful API Design & Implementation</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-database text-success me-2"></i>Advanced Database Design (MySQL/PostgreSQL)</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Software Engineering Principles</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-secondary">Theoretical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-laptop-code text-success me-2"></i>Version Control & DevOps (Git, CI/CD)</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-cloud text-success me-2"></i>Cloud Computing (AWS/Azure Basics)</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-project-diagram text-success me-2"></i>Agile & Scrum Methodology</td>
                            <td class="text-center"><span class="badge bg-info">2 CH</span></td>
                            <td class="text-center"><span class="badge bg-secondary">Theoretical</span></td>
                        </tr>
                        <tr class="table-info">
                            <td class="fw-bold"><i class="fa fa-calculator me-2"></i>Year 3 Total (Software Track)</td>
                            <td class="text-center fw-bold"><span class="badge bg-info fs-6">30 CH</span></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Year 3: Network Engineering Track (Alternative) -->
        <div class="mb-5 wow fadeInUp" data-wow-delay="0.4s">
            <div class="bg-dark text-white p-4 rounded-top">
                <div class="d-flex align-items-center">
                    <i class="fa fa-network-wired fa-3x me-3"></i>
                    <div>
                        <h2 class="mb-0">Year 3 - Network Engineering Track (Alternative)</h2>
                        <p class="mb-0">Cisco CCNA, Security & Infrastructure Design</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60%">Course Name</th>
                            <th width="20%" class="text-center">Credit Hours (CH)</th>
                            <th width="20%" class="text-center">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fa fa-network-wired text-success me-2"></i>Cisco CCNA: Routing & Switching</td>
                            <td class="text-center"><span class="badge bg-info">5 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-network-wired text-success me-2"></i>Advanced Network Design (VLANs, Subnetting)</td>
                            <td class="text-center"><span class="badge bg-info">5 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-shield-alt text-success me-2"></i>Network Security & Firewalls</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-server text-success me-2"></i>Windows & Linux Server Administration</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Wireless Networks & IoT</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-secondary">Theoretical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-laptop-code text-success me-2"></i>Network Monitoring & Troubleshooting</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-cloud text-success me-2"></i>Cloud Networking & Virtual Infrastructure</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Network Protocols & Standards</td>
                            <td class="text-center"><span class="badge bg-info">2 CH</span></td>
                            <td class="text-center"><span class="badge bg-secondary">Theoretical</span></td>
                        </tr>
                        <tr class="table-dark">
                            <td class="fw-bold text-white"><i class="fa fa-calculator me-2"></i>Year 3 Total (Network Track)</td>
                            <td class="text-center fw-bold"><span class="badge bg-dark fs-6">30 CH</span></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Year 4: Software Engineering Track -->
        <div class="mb-5 wow fadeInUp" data-wow-delay="0.5s">
            <div class="bg-warning text-dark p-4 rounded-top">
                <div class="d-flex align-items-center">
                    <i class="fa fa-trophy fa-3x me-3"></i>
                    <div>
                        <h2 class="mb-0">Year 4 - Software Engineering Track (Graduation)</h2>
                        <p class="mb-0">Enterprise Systems, Microservices & Capstone Project</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60%">Course Name</th>
                            <th width="20%" class="text-center">Credit Hours (CH)</th>
                            <th width="20%" class="text-center">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fa fa-laptop-code text-success me-2"></i>Enterprise Application Development</td>
                            <td class="text-center"><span class="badge bg-info">5 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-cubes text-success me-2"></i>Microservices Architecture</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-database text-success me-2"></i>NoSQL Databases (MongoDB, Redis)</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-shield-alt text-success me-2"></i>Web Application Security & Testing</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Software Quality Assurance</td>
                            <td class="text-center"><span class="badge bg-info">2 CH</span></td>
                            <td class="text-center"><span class="badge bg-secondary">Theoretical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-chart-line text-success me-2"></i>Performance Optimization & Scalability</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-briefcase text-success me-2"></i>Industrial Training & Internship</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr class="table-primary">
                            <td><i class="fa fa-project-diagram text-primary me-2"></i><strong>Graduation Project (Software System)</strong></td>
                            <td class="text-center"><span class="badge bg-primary">6 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Project</span></td>
                        </tr>
                        <tr class="table-warning">
                            <td class="fw-bold"><i class="fa fa-calculator me-2"></i>Year 4 Total (Software Track)</td>
                            <td class="text-center fw-bold"><span class="badge bg-warning text-dark fs-6">30 CH</span></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Year 4: Network Engineering Track (Alternative) -->
        <div class="mb-5 wow fadeInUp" data-wow-delay="0.5s">
            <div class="bg-danger text-white p-4 rounded-top">
                <div class="d-flex align-items-center">
                    <i class="fa fa-trophy fa-3x me-3"></i>
                    <div>
                        <h2 class="mb-0">Year 4 - Network Engineering Track (Graduation)</h2>
                        <p class="mb-0">Advanced Security, Enterprise Networks & Capstone Project</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60%">Course Name</th>
                            <th width="20%" class="text-center">Credit Hours (CH)</th>
                            <th width="20%" class="text-center">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fa fa-network-wired text-success me-2"></i>Cisco CCNP: Enterprise Networking</td>
                            <td class="text-center"><span class="badge bg-info">5 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-shield-alt text-success me-2"></i>Cybersecurity & Penetration Testing</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-server text-success me-2"></i>Data Center Management & Virtualization</td>
                            <td class="text-center"><span class="badge bg-info">4 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-lock text-success me-2"></i>Advanced Network Security & Cryptography</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-book text-primary me-2"></i>Network Management & Automation</td>
                            <td class="text-center"><span class="badge bg-info">2 CH</span></td>
                            <td class="text-center"><span class="badge bg-secondary">Theoretical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-wifi text-success me-2"></i>5G Networks & Future Technologies</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-briefcase text-success me-2"></i>Industrial Training & Internship</td>
                            <td class="text-center"><span class="badge bg-info">3 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Practical</span></td>
                        </tr>
                        <tr class="table-primary">
                            <td><i class="fa fa-project-diagram text-primary me-2"></i><strong>Graduation Project (Network Infrastructure)</strong></td>
                            <td class="text-center"><span class="badge bg-primary">6 CH</span></td>
                            <td class="text-center"><span class="badge bg-success">Project</span></td>
                        </tr>
                        <tr class="table-danger">
                            <td class="fw-bold text-white"><i class="fa fa-calculator me-2"></i>Year 4 Total (Network Track)</td>
                            <td class="text-center fw-bold"><span class="badge bg-danger fs-6">30 CH</span></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Total Summary -->
        <div class="row g-4 mb-5 wow fadeInUp" data-wow-delay="0.6s">
            <div class="col-lg-6">
                <div class="card border-info shadow">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="fa fa-code me-2"></i>Software Engineering Track - Total</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mb-0">
                            <tr>
                                <td><strong>Year 1 (Foundation)</strong></td>
                                <td class="text-end"><span class="badge bg-secondary">29 CH</span></td>
                            </tr>
                            <tr>
                                <td><strong>Year 2 (Diploma)</strong></td>
                                <td class="text-end"><span class="badge bg-secondary">32 CH</span></td>
                            </tr>
                            <tr>
                                <td><strong>Year 3 (Bachelor - Software)</strong></td>
                                <td class="text-end"><span class="badge bg-secondary">30 CH</span></td>
                            </tr>
                            <tr>
                                <td><strong>Year 4 (Graduation)</strong></td>
                                <td class="text-end"><span class="badge bg-secondary">30 CH</span></td>
                            </tr>
                            <tr class="table-info">
                                <td class="fw-bold"><i class="fa fa-trophy me-2"></i>4-Year Total</td>
                                <td class="text-end fw-bold"><span class="badge bg-info fs-5">121 CH</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-danger shadow">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0"><i class="fa fa-network-wired me-2"></i>Network Engineering Track - Total</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mb-0">
                            <tr>
                                <td><strong>Year 1 (Foundation)</strong></td>
                                <td class="text-end"><span class="badge bg-secondary">29 CH</span></td>
                            </tr>
                            <tr>
                                <td><strong>Year 2 (Diploma)</strong></td>
                                <td class="text-end"><span class="badge bg-secondary">32 CH</span></td>
                            </tr>
                            <tr>
                                <td><strong>Year 3 (Bachelor - Network)</strong></td>
                                <td class="text-end"><span class="badge bg-secondary">30 CH</span></td>
                            </tr>
                            <tr>
                                <td><strong>Year 4 (Graduation)</strong></td>
                                <td class="text-end"><span class="badge bg-secondary">30 CH</span></td>
                            </tr>
                            <tr class="table-danger">
                                <td class="fw-bold"><i class="fa fa-trophy me-2"></i>4-Year Total</td>
                                <td class="text-end fw-bold"><span class="badge bg-danger fs-5">121 CH</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-primary rounded p-5 text-center wow fadeInUp" data-wow-delay="0.1s">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4"><i class="fa fa-rocket me-2"></i>Ready to Start Your Career?</h2>
                    <p class="text-white-50 mb-4 fs-5">
                        @if(Request::is('information-technology'))
                        Join NCTU's ICT Department and become a skilled software engineer or network specialist. Our industry-focused curriculum prepares you for success.
                        @elseif(Request::is('mechatronics'))
                        Join NCTU's Mechatronics Department and master smart robotics and industrial automation ecosystems.
                        @elseif(Request::is('autotronics'))
                        Join NCTU's Autotronics Department and lead the evolution of advanced electric and hybrid vehicle engineering.
                        @elseif(Request::is('petroleum'))
                        Join NCTU's Petroleum Production Department and drive the core control systems of modern energy processing plants.
                        @elseif(Request::is('renewable-energy'))
                        Join NCTU's Renewable Energy Department and pioneer next-generation clean solar and wind technological solutions.
                        @elseif(Request::is('prosthetics'))
                        Join NCTU's Prosthetics & Orthotics Department and specialize in advanced bionic limbs and bio-mechanical rehabilitative tech.
                        @endif
                    </p>
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
