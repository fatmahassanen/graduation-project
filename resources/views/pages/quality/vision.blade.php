@extends('layouts.app')

@section('title', 'Vision and Mission - Quality Assurance - NCTU')

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

    ul.custom-text li {
        margin-bottom: 8px;
    }
</style>
@endpush

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Vision and Mission</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="{{ route('quality.index') }}">Quality Assurance</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Vision and Mission</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="custom-card">
        <h4 class="custom-title">Vision of the Quality Assurance Unit</h4>
        <p class="custom-text">
            The Quality Assurance Unit at New Cairo Technological University (NCTU) aspires to become a leading
            center locally, regionally, and internationally in implementing quality and academic accreditation
            standards — thereby strengthening the university's position as a distinguished technological institution
            and enabling it to achieve global leadership in education, research, innovation, and community service.
        </p>
    </div>

    <div class="custom-card">
        <h4 class="custom-title">Mission of the Quality Assurance Unit</h4>
        <p class="custom-text">
            The Quality Assurance Unit is committed to developing and implementing a comprehensive and integrated
            quality assurance system that promotes continuous improvement across all academic, research,
            administrative, and community activities of the university, through:
            <br><br>
            • Supporting the university in achieving local and international academic accreditation.
            <br>
            • Aligning technological programs with global standards and labor market requirements.
            <br>
            • Promoting a culture of quality and excellence among students, faculty members, and staff.
            <br>
            • Activating monitoring and evaluation mechanisms to ensure the effectiveness of academic and
            administrative performance.
            <br>
            • Expanding international partnerships and collaborations to enhance institutional excellence and global
            recognition of the university's outcomes.
        </p>
    </div>
</div>

@endsection
