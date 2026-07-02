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
            <span class="fees-badge">Financial Information</span>
            <h2 class="fees-heading">New Applicant Tuition Categories</h2>
            <div class="fees-divider mx-auto mb-5"></div>
        </div>

        <p class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.3s" style="max-width:860px;font-size:1.05rem;line-height:1.85;color:#666;">
            "Transparent and continuously updated information about tuition fees, financial aid programs, and the wide range
            of scholarship opportunities designed to support talented and ambitious students at New Cairo University of
            Technology, ensuring equal access to quality education for everyone."
        </p>

        <div class="row g-4 justify-content-center mb-5 wow fadeInUp" data-wow-delay="0.5s">
            <div class="col-lg-10">
                <div class="fees-table-wrapper p-4 p-md-5">
                    <h3 class="text-center mb-2 fees-year-heading">Academic Year {{ $academicYear }}</h3>
                    @if($announcement)
                        <p class="text-center mb-4" style="color:#555;font-size:0.97rem;">{{ $announcement }}</p>
                    @endif
                    <div class="table-responsive">
                        <table class="fee-table w-100 mt-3">
                            <thead>
                                <tr>
                                    <th class="py-3 ps-4 text-start">Year / Category</th>
                                    <th class="py-3 pe-4 text-end">Annual Tuition (EGP)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fees as $fee)
                                    <tr class="fee-row">
                                        <td class="py-4 ps-4 fw-bold fee-year-cell">{{ $fee->year_range }}</td>
                                        <td class="py-4 pe-4 text-end">
                                            <span class="fee-amount-badge">{{ number_format($fee->amount, 0) }} EGP</span>
                                        </td>
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
                <div class="fees-info-box h-100">
                    <h3 class="mb-4"><i class="fa fa-graduation-cap me-2"></i>Scholarship Programs</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="fa fa-check me-2" style="color:#D08301;"></i><strong>Merit Scholarships:</strong> For students with outstanding academic performance.</li>
                        <li class="mb-3"><i class="fa fa-check me-2" style="color:#D08301;"></i><strong>Special Support:</strong> Scholarships dedicated to students with special needs (Disabilities).</li>
                        <li class="mb-3"><i class="fa fa-check me-2" style="color:#D08301;"></i><strong>Eligibility:</strong> Maintaining a high GPA is a key requirement for most aid.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.1s">
                <div class="fees-info-box h-100">
                    <h3 class="mb-4"><i class="fa fa-info-circle me-2"></i>Important Notes</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fa fa-arrow-right me-2 small" style="color:#D08301;"></i>Follow official social media for latest updates.</li>
                        <li class="mb-2"><i class="fa fa-arrow-right me-2 small" style="color:#D08301;"></i>Payments are made in EGP via official bank branches.</li>
                        <li class="mb-2"><i class="fa fa-arrow-right me-2 small" style="color:#D08301;"></i>Discounts are applied after Registrar eligibility verification.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.7s">
            <a href="{{ route('faculties-requirements') }}" class="fees-cta-btn px-5 py-3">
                Check Required Documents <i class="fa fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .fees-badge {
        display: inline-block;
        color: #D08301;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 10px;
    }
    .fees-heading {
        font-weight: 800;
        color: #181d38;
        font-size: clamp(1.6rem,3vw,2.2rem);
        margin-bottom: 14px;
    }
    .fees-divider {
        width: 50px; height: 4px;
        background: #D08301;
        border-radius: 2px;
    }
    .fees-table-wrapper {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 6px 32px rgba(24,29,56,0.09);
    }
    .fees-year-heading {
        color: #1a3a6e;
        font-weight: 700;
        font-size: 1.4rem;
    }
    .fee-table {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 14px;
        overflow: hidden;
    }
    .fee-table thead tr {
        background: linear-gradient(135deg, #1a3a6e, #2356c7);
    }
    .fee-table thead th {
        color: #fff !important;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
    }
    .fee-row:nth-child(odd)  { background: #f8faff; }
    .fee-row:nth-child(even) { background: #ffffff; }
    .fee-row { transition: background 0.2s; }
    .fee-row:hover { background: #eef2fb !important; }
    .fee-year-cell { color: #181d38; font-size: 1rem; }
    .fee-amount-badge {
        display: inline-block;
        background: #D08301;
        color: #fff;
        padding: 6px 18px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
    }
    .fees-info-box {
        background: #fff;
        padding: 32px;
        border-left: 5px solid #D08301;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(24,29,56,0.07);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .fees-info-box:hover {
        transform: translateY(-8px);
        box-shadow: 0 14px 36px rgba(24,29,56,0.14);
    }
    .fees-info-box h3 { color: #1a3a6e; font-weight: 700; font-size: 1.15rem; }
    .fees-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #1a3a6e, #2356c7);
        color: #fff !important;
        border: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 4px 16px rgba(26,58,110,0.25);
    }
    .fees-cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(26,58,110,0.35);
        color: #fff !important;
    }
</style>
@endpush
