@extends('layouts.app')

@section('title', 'Tuition Fees & Scholarships - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Tuition Fees & Scholarships</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="/">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Admissions</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Financial Information</h6>
            <h1 class="mb-5">New Applicant Tuition Categories</h1>
        </div>

        <p class="subtitle text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.3s" style="max-width: 900px; font-size: 1.1rem; line-height: 1.8; color: #666;">
            "Transparent and continuously updated information about tuition fees, financial aid programs, and the wide range
            of scholarship opportunities designed to support talented and ambitious students at New Cairo University of
            Technology, ensuring equal access to quality education for everyone."
        </p>

        <div class="row g-4 justify-content-center mb-5 wow fadeInUp" data-wow-delay="0.5s">
            <div class="col-lg-12">
                <div class=" p-4 rounded shadow-sm border-top border-5 border-primary">
                    <h2 class="text-center mb-4" style="color: var(--brand-blue);">Academic Year {{ $academicYear }}</h2>
                    @if($announcement)
                        <p class="text-center">{{ $announcement }}</p>
                    @endif

                    <div class="table-responsive">
                        <table class="fee-table w-100 shadow-sm rounded overflow-hidden mt-4">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th class="py-3">Year / Category</th>
                                    <th class="py-3">Annual Tuition (EGP)</th>
                                </tr>
                            </thead>
                            <tbody class="text-center bg-white">
                                @foreach($fees as $fee)
                                    <tr class="border-bottom">
                                        <td class="py-4 fw-bold">{{ $fee->year_range }}</td>
                                        <td class="py-4"><span class="badge bg-success fs-6">{{ number_format($fee->amount, 0) }} EGP</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 

        <div class="row g-4">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                <div class="info-box h-100">
                    <h3 class="mb-4"><i class="fa fa-graduation-cap me-2"></i>Scholarship Programs</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="fa fa-check text-primary me-2"></i><strong>Merit Scholarships:</strong> For students with outstanding academic performance.</li>
                        <li class="mb-3"><i class="fa fa-check text-primary me-2"></i><strong>Special Support:</strong> Scholarships dedicated to students with special needs (Disabilities).</li>
                        <li class="mb-3"><i class="fa fa-check text-primary me-2"></i><strong>Eligibility:</strong> Maintaining a high GPA is a key requirement for most aid.</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.1s">
                <div class="info-box h-100">
                    <h3 class="mb-4"><i class="fa fa-info-circle me-2"></i>Important Notes</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fa fa-arrow-right text-primary me-2 small"></i>Follow official social media for latest updates.</li>
                        <li class="mb-2"><i class="fa fa-arrow-right text-primary me-2 small"></i>Payments are made in EGP via official bank branches.</li>
                        <li class="mb-2"><i class="fa fa-arrow-right text-primary me-2 small"></i>Discounts are applied after Registrar eligibility verification.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.7s">
            <a href="{{ route('faculties-requirements') }}" class="btn btn-primary px-5 py-3 rounded-pill shadow">
                Check Required Documents <i class="fa fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    :root {
      --brand-blue: #1a096e;
    }

    .fee-table {
      border-collapse: separate;
      border-spacing: 0;
    }

    .fee-table th {
      background-color: var(--brand-blue) !important;
      color: white !important;
    }

    .info-box {
      background: #fdfdfd;
      padding: 30px;
      border-left: 6px solid var(--primary);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      border-radius: 8px;
      transition: 0.3s;
    }

    .info-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .info-box h3 {
      color: var(--brand-blue);
      font-weight: 700;
    }
</style>
@endpush
