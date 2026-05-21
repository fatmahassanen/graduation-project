@extends('layouts.app')

@section('title', 'Measurement & Assessment - NCTU')

@section('content')
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Measurement & Assessment Center</h1>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container text-center">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-9 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Quality of Assessment</h6>
                <h1 class="mb-4">Achieving Excellence in Educational Evaluation</h1>
                <p class="fs-5 text-muted">The center is dedicated to developing the university’s examination system by adopting modern assessment methodologies. We focus on ensuring that evaluation processes are objective, fair, and aligned with international quality standards.</p>
            </div>
        </div>

        <div class="row g-4 text-start">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                <h3 class="mb-4 border-start border-5 border-primary ps-3">Core Responsibilities</h3>
                <ul class="list-unstyled">
                    <li class="mb-3 fs-5"><i class="fa fa-check-circle text-primary me-2"></i>Developing specialized Question Banks for all academic courses.</li>
                    <li class="mb-3 fs-5"><i class="fa fa-check-circle text-primary me-2"></i>Implementing and managing the Secure E-Examination System.</li>
                    <li class="mb-3 fs-5"><i class="fa fa-check-circle text-primary me-2"></i>Analyzing examination results statistically to improve teaching quality.</li>
                    <li class="mb-3 fs-5"><i class="fa fa-check-circle text-primary me-2"></i>Training faculty members on modern "Item Writing" techniques.</li>
                </ul>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.1s">
                <div class="p-5 bg-light rounded shadow-sm">
                    <h4>Measurement Values</h4>
                    <p>Accuracy, Transparency, and Fairness are our guiding principles. We believe that a correct assessment is the first step toward producing a truly qualified technologist.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
