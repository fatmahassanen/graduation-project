@extends('layouts.app')

@section('title', 'International Cooperation - NCTU')

@section('content')
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">International Cooperation</h1>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center mb-5">
                <div class="text-center">
                    <h6 class="section-title bg-white text-center text-primary px-3">Global Outreach</h6>
                </div>
            <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.1s">


                <h1 class="mb-4">Bridging NCTU with Global Innovation</h1>
                <p>The International Cooperation Unit at New Cairo Technological University serves as the university's window to the world. We actively seek partnerships with prestigious international universities and industrial giants to ensure our students receive a globally recognized education.</p>
                <p><strong>Our Strategic Focus:</strong> Establishing international dual-degree programs, managing joint research grants, and facilitating faculty/student exchange programs with countries leading in technology such as Germany, China, and South Korea.</p>
            </div>
            <div class="col-lg-5 text-center wow zoomIn" data-wow-delay="0.3s">
                <i class="fa fa-globe-africa fa-10x text-primary opacity-10"></i>
            </div>
        </div>

        <div class="row g-4">
            <h3 class="text-center mb-5">Our Main Functions</h3>
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="p-4 shadow-sm border rounded text-center h-100">
                    <i class="fa fa-handshake fa-3x text-primary mb-3"></i>
                    <h5>Strategic Protocols</h5>
                    <p class="small text-muted">Drafting and managing Memorandums of Understanding (MoUs) with international educational and industrial partners.</p>
                </div>
            </div>
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="p-4 shadow-sm border rounded text-center h-100">
                    <i class="fa fa-graduation-cap fa-3x text-primary mb-3"></i>
                    <h5>Scholarships & Grants</h5>
                    <p class="small text-muted">Managing international scholarship opportunities for students and competitive research grants for faculty members.</p>
                </div>
            </div>
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.5s">
                <div class="p-4 shadow-sm border rounded text-center h-100">
                    <i class="fa fa-exchange-alt fa-3x text-primary mb-3"></i>
                    <h5>Exchange Programs</h5>
                    <p class="small text-muted">Coordinating student and faculty mobility programs to share expertise and cultural experiences globally.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
