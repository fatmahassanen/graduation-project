@extends('layouts.app')

@section('title', 'Industry & Energy Technology - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Industry & Energy Technology</h1>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">

        <div class="row g-5 align-items-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-12 text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">College Overview</h6>
                <h1 class="mb-4">Driving the Industrial Revolution</h1>
                <p class="mb-4 fs-5">The Faculty of Industry and Energy Technology is the heartbeat of New Cairo Technological University. It is specifically designed to meet the demands of Egypt's industrial future. Our approach shifts from traditional learning to <strong>"Competency-Based Education,"</strong> where students spend 60% of their time in practical training, labs, and real factories.</p>
            </div>
        </div>

        <div class="row g-4 mb-5 justify-content-center text-center">
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="p-4 shadow-sm border rounded bg-white h-100 border-top border-5 border-primary">
                    <i class="fa fa-eye fa-3x text-primary mb-3"></i>
                    <h3>Our Vision</h3>
                    <p>To be a regional leader in tech-education, producing innovators who redefine industrial standards through sustainable energy and smart manufacturing.</p>
                </div>
            </div>
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.3s">
                <div class="p-4 shadow-sm border rounded bg-white h-100 border-top border-5 border-primary">
                    <i class="fa fa-bullseye fa-3x text-primary mb-3"></i>
                    <h3>Our Mission</h3>
                    <p>To provide high-quality, practical programs that equip students with the technical mastery and leadership mindset needed for the global market.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center text-center my-5 py-5 bg-light rounded wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-8">
                <h6 class="section-title bg-light text-center text-primary px-3">Our Dean</h6>
                <h2 class="mb-4">{{ $dean->full_name }}</h2>
                <p class="fs-5">"{{ Str::limit(explode("\n", $dean->welcome_text)[0], 150) }}"</p>
                <a href="{{ route('dean1') }}" class="btn btn-primary px-5 py-3 rounded-pill">Meet the Dean</a>
            </div>
        </div>

        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Departments</h6>
            <h1 class="mb-5">Programs & Career Paths</h1>
        </div>

        <div class="row g-4">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="p-4 shadow rounded border h-100 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-laptop-code fa-3x text-primary me-3"></i>
                        <h3 class="mb-0">ICT Department</h3>
                    </div>
                    <p><strong>Description:</strong> This department focuses on the digital backbone of industry. It covers software engineering, web development (PHP/Laravel), cybersecurity, and cloud computing.</p>
                    <p><strong>Qualifies you for:</strong> Becoming a Full-Stack Developer, Network Security Engineer, or IT Consultant in smart factories and tech companies.</p>
                    <a href="{{ url('/courses#ict') }}" class="btn btn-outline-primary rounded-pill px-4">View 4-Year Plan</a>
                </div>
            </div>

            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="p-4 shadow rounded border h-100 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-robot fa-3x text-primary me-3"></i>
                        <h3 class="mb-0">Mechatronics</h3>
                    </div>
                    <p><strong>Description:</strong> A fusion of mechanics, electronics, and AI. You learn how to design, build, and maintain robots and automated production lines.</p>
                    <p><strong>Qualifies you for:</strong> Working as a Robotics Engineer, Automation Specialist, or Maintenance Manager in high-tech industrial plants.</p>
                    <a href="{{ url('/courses#mechatronics') }}" class="btn btn-outline-primary rounded-pill px-4">View 4-Year Plan</a>
                </div>
            </div>

            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="p-4 shadow rounded border h-100 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-car fa-3x text-primary me-3"></i>
                        <h3 class="mb-0">Autotronics</h3>
                    </div>
                    <p><strong>Description:</strong> Focuses on the "brain" of modern vehicles. It includes engine management systems, sensors, and the technology of electric/hybrid cars.</p>
                    <p><strong>Qualifies you for:</strong> Automotive Systems Engineer or Electric Vehicle (EV) Specialist in modern service centers and car manufacturing companies.</p>
                    <a href="{{ url('/courses#autotronics') }}" class="btn btn-outline-primary rounded-pill px-4">View 4-Year Plan</a>
                </div>
            </div>

            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="p-4 shadow rounded border h-100 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-solar-panel fa-3x text-primary me-3"></i>
                        <h3 class="mb-0">Renewable Energy</h3>
                    </div>
                    <p><strong>Description:</strong> Specialized in sustainable power sources. It covers solar panels, wind turbines, and the future of Green Hydrogen production.</p>
                    <p><strong>Qualifies you for:</strong> Energy Consultant, Solar Plant Supervisor, or Environmental Engineer in the transition to clean energy.</p>
                    <a href="{{ url('/courses#energy') }}" class="btn btn-outline-primary rounded-pill px-4">View 4-Year Plan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
