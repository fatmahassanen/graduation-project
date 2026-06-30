@extends('layouts.app')

@section('title', 'Objectives - Quality Assurance - NCTU')

@push('styles')
<style>
    .custom-card {
        border-left: 6px solid #D08301;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 30px;
    }

    .custom-title {
        color: #1a096e;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .custom-text {
        text-align: justify;
        color: #333;
        line-height: 1.8;
    }
</style>
@endpush

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Objectives of the Quality Assurance Unit</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="{{ route('quality.index') }}">Quality Assurance</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Objectives</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="custom-card">
        <h4 class="custom-title">Objectives of the Quality Assurance Unit</h4>
        <p class="custom-text">
            1. Promote and institutionalize a culture of quality and organizational excellence among all university
            members.
            <br><br>
            2. Develop and maintain integrated internal systems for quality assurance and accreditation in
            accordance with national and international standards.
            <br><br>
            3. Prepare and monitor strategic and continuous improvement plans for academic programs and research
            activities.
            <br><br>
            4. Support colleges and programs in obtaining international academic accreditation in addition to local
            accreditation.
            <br><br>
            5. Monitor academic and administrative performance indicators and align them with global labor market
            needs.
            <br><br>
            6. Build the capacities of faculty members, staff, and students in the areas of quality, research, and
            innovation.
            <br><br>
            7. Enhance the global reputation of the university through adopting best international practices and
            developing strategic partnerships with renowned educational and research institutions.
        </p>
    </div>
</div>

@endsection
