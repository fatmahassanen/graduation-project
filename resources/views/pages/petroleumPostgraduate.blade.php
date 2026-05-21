@extends('layouts.app')

@section('title', 'Master in Petroleum Technology - NCTU')

@section('content')
<style>
    section { padding: 60px 0; border-bottom: 1px solid #f1f1f1; }
    section h2 { font-size: 2.2rem; font-weight: 700; color: #1a096e; margin-bottom: 30px; position: relative; display: inline-block; }
    section h2::after { content: ""; width: 60%; height: 4px; background: #D08301; position: absolute; bottom: -10px; left: 0; border-radius: 2px; }
    .highlight-box { background: #f6f8ff; border-left: 6px solid #D08301; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); transition: 0.3s; }
    .highlight-box:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(208, 131, 1, 0.15); }
    .back-btn { display: inline-block; margin: 40px auto; padding: 12px 35px; background: #D08301; color: white; border-radius: 50px; font-weight: 600; text-decoration: none; }
</style>

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Master’s in Petroleum Technology</h1>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <section class="wow fadeInUp" data-wow-delay="0.1s">
            <h2>Admission Requirements</h2>
            <div class="highlight-box">
                <p>Applicants must hold a Bachelor’s degree in Petroleum Engineering, Chemical Engineering, or a related field from a recognized university. A minimum grade of “Good” is required. Candidates should have a strong understanding of fluid mechanics, thermodynamics, and geological principles.</p>
                <a href="{{ route('postgraduate-apply') }}" class="btn btn-primary rounded-pill px-4 py-2 mt-3">Apply Now</a>
            </div>
        </section>

        <section class="wow fadeInUp" data-wow-delay="0.2s">
            <h2>Tuition Fees & Aid</h2>
            <div class="highlight-box">
                <p>Tuition is approximately <strong>12,000 EGP per semester</strong>. We offer research grants for students specializing in advanced oil recovery and sustainable extraction methods in collaboration with national petroleum companies.</p>
            </div>
        </section>

        <section class="wow fadeInUp" data-wow-delay="0.3s">
            <h2>Research & Industry</h2>
            <div class="highlight-box">
                <p>Our program is partnered with leading oil and gas firms in Egypt. Students engage in practical research involving <strong>drilling technologies, reservoir management, and refinery optimization</strong>, preparing them for top-tier roles in the energy sector.</p>
            </div>
        </section>

        <div class="text-center mt-5"><a href="{{ route('postgraduate-studies') }}" class="back-btn">← Back to Programs</a></div>
    </div>
</div>
@endsection
