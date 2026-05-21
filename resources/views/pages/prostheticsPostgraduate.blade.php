@extends('layouts.app')

@section('title', 'Master in Prosthetics & Orthotics - NCTU')

@section('content')
<style>
    section { padding: 60px 0; border-bottom: 1px solid #f1f1f1; }
    section h2 { font-size: 2.2rem; font-weight: 700; color: #1a096e; margin-bottom: 30px; position: relative; display: inline-block; }
    section h2::after { content: ""; width: 60%; height: 4px; background: #D08301; position: absolute; bottom: -10px; left: 0; border-radius: 2px; }
    .highlight-box { background: #f6f8ff; border-left: 6px solid #D08301; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); }
    .back-btn { display: inline-block; margin: 40px auto; padding: 12px 35px; background: #D08301; color: white; border-radius: 50px; font-weight: 600; text-decoration: none; }
</style>

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Master’s in Prosthetics & Orthotics</h1>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <section class="wow fadeInUp">
            <h2>Admission Requirements</h2>
            <div class="highlight-box">
                <p>Candidates must have a Bachelor’s degree in Applied Health Sciences, Biomedical Engineering, or Prosthetics Technology. Applicants must demonstrate a passion for rehabilitation science and innovative medical design to improve patient mobility.</p>
                <a href="{{ route('postgraduate-apply') }}" class="btn btn-primary rounded-pill px-4 py-2 mt-3">Apply Now</a>
            </div>
        </section>

        <section class="wow fadeInUp">
            <h2>Tuition & Scholarships</h2>
            <div class="highlight-box">
                <p>The semester fee is <strong>12,000 EGP</strong>. Special scholarships are available for high-achieving students who focus their research on <strong>3D-printed bionic limbs</strong> and low-cost rehabilitation solutions.</p>
            </div>
        </section>

        <section class="wow fadeInUp">
            <h2>Partnerships</h2>
            <div class="highlight-box">
                <p>We collaborate with military and civil rehabilitation centers. Students work on <strong>biomechanical analysis and smart limb control</strong>, ensuring their research directly impacts the lives of people with disabilities in Egypt.</p>
            </div>
        </section>

        <div class="text-center mt-5"><a href="{{ route('postgraduate-studies') }}" class="back-btn">← Back to Programs</a></div>
    </div>
</div>
@endsection
