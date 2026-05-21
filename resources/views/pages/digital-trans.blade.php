@extends('layouts.app')

@section('title', 'Digital Transformation Unit - NCTU')

@section('content')
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Digital Transformation Unit</h1>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center">
            <h6 class="section-title bg-white text-center text-primary px-3">Unit Overview</h6>
        </div>
        <div class="row g-5 align-items-center mb-5">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="mb-4">Building a Smart Technological Campus</h1>
                <p class="mb-4 fs-5">The Digital Transformation Unit at NCTU is the backbone of the university's technical evolution. It aims to create an integrated digital ecosystem that connects students, faculty, and administration through a unified smart platform, ensuring efficiency, transparency, and data-driven decision-making.</p>
            </div>
        </div>

        <div class="row g-4 mb-5 text-center">
            <div class="col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="p-4 border rounded shadow-sm bg-light h-100">
                    <h4 class="text-primary"><i class="fa fa-eye me-2"></i>Vision</h4>
                    <p>To lead NCTU towards becoming a premier 4th Generation Smart University, globally recognized for its digital infrastructure and innovative tech-services.</p>
                </div>
            </div>
            <div class="col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="p-4 border rounded shadow-sm bg-light h-100">
                    <h4 class="text-primary"><i class="fa fa-bullseye me-2"></i>Mission</h4>
                    <p>Harnessing cutting-edge technologies to digitize academic and administrative workflows, enhancing the educational experience through secure and reliable digital solutions.</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">

                <div class="text-center">
                    <h6 class="section-title bg-white text-center text-primary px-3">Strategic Goals & Responsibilities</h6>
                </div> <br><br>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex mb-4">
                            <div class="btn-primary btn-sm-square rounded-circle me-3" style="width: 45px; height: 45px;"><i class="fa fa-server"></i></div>
                            <div>
                                <h5>Infrastructure Development</h5>
                                <p>Supervising the university's data centers, high-speed networks, and cloud computing resources to ensure 24/7 availability.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex mb-4">
                            <div class="btn-primary btn-sm-square rounded-circle me-3" style="width: 45px; height: 45px;"><i class="fa fa-user-shield"></i></div>
                            <div>
                                <h5>E-Services & Portals</h5>
                                <p>Managing the "Student Information System" (SIS) and "Learning Management System" (LMS) for seamless digital interaction.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex mb-4">
                            <div class="btn-primary btn-sm-square rounded-circle me-3" style="width: 45px; height: 45px;"><i class="fa fa-database"></i></div>
                            <div>
                                <h5>Decision Support Systems</h5>
                                <p>Collecting and analyzing university data to provide accurate reports and KPIs for top management and university leaders.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex mb-4">
                            <div class="btn-primary btn-sm-square rounded-circle me-3" style="width: 45px; height: 45px;"><i class="fa fa-lock"></i></div>
                            <div>
                                <h5>Cybersecurity & Privacy</h5>
                                <p>Implementing advanced security protocols to protect university assets and sensitive student/staff data from digital threats.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
