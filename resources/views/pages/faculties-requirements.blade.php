@extends('layouts.app')

@section('title', 'Required Documents - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Admission Requirements</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="/">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Requirements</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Registration Guide</h6>
            <h1 class="mb-5">Required Documents</h1>
        </div>

        <div class="row g-4">
            @php
                $docs = [
                    "Original high school certificate or equivalent + 5 digital copies.",
                    "Final college nomination form after coordination results.",
                    "Original birth certificate + 5 digital copies.",
                    "Form 2 and 6 / Military status certificate (for male students).",
                    "6 recent personal photos (size 4×6) with the student’s name on them.",
                    "3 copies of the student’s national ID card.",
                    "3 copies of the guardian’s national ID card.",
                    "Copy of the payment receipt for tuition and file opening fees.",
                    "Black capsule plastic file folder."
                ];
            @endphp

            @foreach($docs as $index => $doc)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 * ($index % 3 + 1) }}s">
                <div class="doc-card p-4 h-100 shadow-sm rounded bg-white border-start border-5 border-primary">
                    <div class="d-flex align-items-center">
                        <div class="btn-sm-square bg-primary text-white rounded-circle me-3">
                            <i class="fa fa-file-alt"></i>
                        </div>
                        <p class="mb-0 text-dark fw-medium">{{ $doc }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.5s">
            <a href="{{ route('admission.create') }}" class="btn btn-primary px-5 py-3 rounded-pill shadow">
                 Apply for Admission <i class="fa fa-arrow-right me-2"></i>
            </a>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .doc-card {
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }
    .doc-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.1) !important;
        border-color: var(--primary) !important;
    }
    .btn-sm-square {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* تعديل بسيط للون الـ Primary لو محتاجة تظبطيه مع الـ Blue بتاعك */
    :root {
        --primary: #040faa;
    }
</style>
@endpush
