@extends('layouts.app')

@section('title', 'Master in Renewable Energy - NCTU')

@section('content')

<style>
    /* تحسينات إضافية لتنسيق الصناديق والسكاشن */
    section {
        padding: 60px 0;
        border-bottom: 1px solid #f1f1f1;
    }

    section h2 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1a096e;
        margin-bottom: 30px;
        position: relative;
        display: inline-block;
    }

    section h2::after {
        content: "";
        width: 60%;
        height: 4px;
        background: #D08301;
        position: absolute;
        bottom: -10px;
        left: 0;
        border-radius: 2px;
    }

    .highlight-box {
        background: #f6f8ff;
        border-left: 6px solid #D08301;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .highlight-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(208, 131, 1, 0.15);
        background: #ffffff;
    }

    .highlight-box p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #444;
        margin-bottom: 0;
    }

    .back-btn {
        display: inline-block;
        margin: 40px auto;
        padding: 12px 35px;
        background: #D08301;
        color: white;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .back-btn:hover {
        background: #1a096e;
        color: #fff;
        transform: translateX(-5px);
    }
</style>

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Master’s in Renewable Energy</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/postgraduate') }}">Postgraduate</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Renewable Energy</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-xxl py-5">
    <div class="container">
        <section class="wow fadeInUp" data-wow-delay="0.1s">
            <h2>Admission Requirements</h2>
            <div class="highlight-box mt-3">
                <p>
                    Candidates must hold a Bachelor’s degree in Electrical, Mechanical, or Energy Engineering — or a closely related
                    field — with a minimum overall grade of “Good” (GPA 3.0/4.0).
                    Applicants are expected to demonstrate strong analytical skills and motivation for research in sustainable
                    energy technologies. Relevant professional or research experience in the energy sector is a plus.
                </p>
                <div class="mt-4">
                    <a href="{{ route('postgraduate-apply') }}" class="btn btn-primary rounded-pill px-4 py-2">Apply Now</a>
                </div>
            </div>
        </section>

        <section class="wow fadeInUp" data-wow-delay="0.2s">
            <h2>Tuition Fees & Financial Aid</h2>
            <div class="highlight-box mt-3">
                <p>
                    The tuition fee is approximately <strong>12,000 EGP per semester</strong> for local students.
                    International students are welcome, with tuition adjusted accordingly.
                    A limited number of <strong>scholarships and assistantships</strong> are available for high-achieving
                    applicants, especially those contributing to ongoing research projects.
                </p>
            </div>
        </section>

        <section class="wow fadeInUp" data-wow-delay="0.3s">
            <h2>Research & Industry Partnerships</h2>
            <div class="highlight-box mt-3">
                <p>
                    The Energy Technology program collaborates with leading national and international partners in renewable energy,
                    smart grids, and power management industries. Students gain practical exposure through
                    <strong>internships, industrial visits, and joint research initiatives</strong>.
                    These collaborations open direct pathways for graduates to join energy companies and research centers supporting Egypt’s 2030 Vision.
                </p>
            </div>
        </section>

        <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.4s">
            <a href="{{ route('postgraduate-studies') }}" class="back-btn">
                <i class="fa fa-arrow-left me-2"></i> Back to All Programs
            </a>
        </div>
    </div>
</div>

@endsection
