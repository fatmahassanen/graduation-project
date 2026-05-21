@extends('layouts.app')

@section('title', 'Master in Information Technology - NCTU')

@section('content')

<style>
    /* تحسينات التصميم الخاصة بالصفحة */
    section {
        padding: 60px 0;
        border-bottom: 1px solid #f1f1f1;
        position: relative;
    }

    section h2 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1a096e;
        margin-bottom: 30px;
        position: relative;
    }

    section h2::after {
        content: "";
        width: 100px;
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
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .highlight-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(208, 131, 1, 0.15);
    }

    .highlight-box p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
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
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background: #1a096e;
        color: #fff;
        transform: translateX(-5px);
    }
</style>

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Master’s in Information Technology</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/postgraduate') }}">Postgraduate</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Information Technology</li>
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
                    Applicants must hold a Bachelor’s degree in Computer Science, Information Technology, or Software Engineering — or a closely related field — with a minimum grade of “Good” (GPA 3.0/4.0).
                    Candidates should demonstrate proficiency in programming languages (C++, Java, or Python) and have a solid foundation in database management.
                    Professional certifications or industrial experience in backend development is highly preferred.
                </p>
                <div class="mt-4">
                    <a href="{{ route('postgraduate-apply') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow">Apply Now</a>
                </div>
            </div>
        </section>

        <section class="wow fadeInUp" data-wow-delay="0.2s">
            <h2>Tuition Fees & Financial Aid</h2>
            <div class="highlight-box mt-3">
                <p>
                    The semester fee for the Information Technology Master’s program is approximately <strong>12,000 EGP</strong>.
                    The university offers several <strong>financial aid packages</strong> for students working on innovative graduation projects or those with high academic performance.
                    Teaching assistantship opportunities are also available for selected graduate students.
                </p>
            </div>
        </section>

        <section class="wow fadeInUp" data-wow-delay="0.3s">
            <h2>Research & Industry Partnerships</h2>
            <div class="highlight-box mt-3">
                <p>
                    Our IT postgraduate program is built in collaboration with Egypt's leading tech hubs and international software companies.
                    Students get hands-on experience through <strong>advanced labs focusing on Artificial Intelligence, Cybersecurity, and Data Science</strong>.
                    We provide direct pathways for students to contribute to national digital transformation projects, ensuring their research has a real-world impact.
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
