@extends('layouts.app')

@section('title', 'Master in Autotronics Engineering - NCTU')

@section('content')
<style>
    section { padding: 60px 0; border-bottom: 1px solid #f1f1f1; }
    section h2 { font-size: 2.2rem; font-weight: 700; color: #1a096e; margin-bottom: 30px; position: relative; display: inline-block; }
    section h2::after { content: ""; width: 60%; height: 4px; background: #D08301; position: absolute; bottom: -10px; left: 0; border-radius: 2px; }
    .highlight-box { background: #f6f8ff; border-left: 6px solid #D08301; padding: 30px; border-radius: 12px; }
    .back-btn { display: inline-block; margin: 40px auto; padding: 12px 35px; background: #D08301; color: white; border-radius: 50px; font-weight: 600; text-decoration: none; }
</style>

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Master’s in Autotronics Engineering</h1>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <section class="wow fadeInUp">
            <h2>Admission Requirements</h2>
            <div class="highlight-box">
                <p>Applicants should hold a Bachelor’s degree in Autotronics, Mechanical Engineering, or Automotive Engineering. Strong knowledge of <strong>engine management systems, sensors, and electronic control units (ECUs)</strong> is essential.</p>
                <a href="{{ route('postgraduate-apply') }}" class="btn btn-primary rounded-pill px-4 py-2 mt-3">Apply Now</a>
            </div>
        </section>

        <section class="wow fadeInUp">
            <h2>Tuition & Funding</h2>
            <div class="highlight-box">
                <p>Fees are set at <strong>12,000 EGP per semester</strong>. Financial aid is provided for students researching <strong>Electric Vehicles (EVs)</strong> and hybrid propulsion systems to support Egypt's green transportation initiatives.</p>
            </div>
        </section>

        <section class="wow fadeInUp">
            <h2>Industry Links</h2>
            <div class="highlight-box">
                <p>We work closely with international car manufacturers and modern service centers. Students gain experience in <strong>vehicle diagnostics, AI-assisted driving, and smart infotainment systems</strong>, leading to high-demand careers in the automotive tech market.</p>
            </div>
        </section>

        <div class="text-center mt-5"><a href="{{ route('postgraduate-studies') }}" class="back-btn">← Back to Programs</a></div>
    </div>
</div>
@endsection
