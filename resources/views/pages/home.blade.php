@extends('layouts.app')

@section('title', 'New Cairo University of Technology - Home')

@push('styles')
<style>
/* ============================================================
   HOME PAGE STYLES
   ============================================================ */

/* ----- HERO ----- */
.hero-slider {
    position: relative;
    overflow: hidden;
    height: 100vh;
    min-height: 560px;
    max-height: 800px;
}
.hero-slide {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(15,20,50,0.85) 40%, rgba(15,20,50,0.3) 100%);
}
.hero-content {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
}
.hero-title {
    font-size: clamp(2rem, 5vw, 3.6rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.15;
    letter-spacing: -0.5px;
    text-shadow: 2px 4px 12px rgba(0,0,0,0.35);
    animation: heroFadeUp 0.9s ease both;
}
.hero-title span { color: #D08301; }
.hero-sub {
    font-size: clamp(1rem, 2vw, 1.25rem);
    color: rgba(255,255,255,0.9);
    margin: 1rem 0 0.5rem;
    animation: heroFadeUp 1.1s ease both;
}
.hero-divider {
    width: 48px; height: 3px;
    background: #D08301;
    margin: 0.75rem 0 1.5rem;
    animation: heroFadeUp 1.2s ease both;
}
.hero-btn {
    background: #D08301;
    border: none;
    color: #fff;
    padding: 0.75rem 2rem;
    font-weight: 700;
    font-size: 0.95rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    border-radius: 3px;
    transition: background 0.3s, transform 0.3s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    animation: heroFadeUp 1.3s ease both;
}
.hero-btn:hover { background: #b36e00; transform: translateX(4px); color: #fff; }
@keyframes heroFadeUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}
@media (max-width: 576px) {
    .hero-slider { height: 70vw; min-height: 320px; }
}

/* ----- SECTION HEADINGS ----- */
.section-badge {
    display: inline-block;
    color: #D08301;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    margin-bottom: 0.6rem;
}
.section-heading {
    font-size: clamp(1.6rem, 3vw, 2.1rem);
    font-weight: 800;
    color: #181d38;
    margin-bottom: 0;
    line-height: 1.2;
}
.section-underline {
    width: 48px; height: 3px;
    background: #D08301;
    border-radius: 2px;
    margin: 0.75rem auto 0;
}
.section-underline.start { margin-left: 0; }

/* ----- ABOUT ----- */
.about-text-card {
    background: #fff;
    border-radius: 16px;
    padding: 38px 40px;
    box-shadow: 0 8px 32px rgba(24,29,56,0.08);
    height: 100%;
    border-left: 5px solid #D08301;
    position: relative;
    overflow: hidden;
}
.about-text-card::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 130px; height: 130px;
    background: rgba(208,131,1,0.06);
    border-radius: 50%;
}
.about-text-card p { font-size: 1rem; line-height: 1.85; color: #444; }
.about-video-wrap {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.14);
    height: 100%;
    min-height: 300px;
    background: #000;
}
.about-video-wrap video { width:100%; height:100%; max-height:430px; object-fit:cover; display:block; }

/* ----- DEPARTMENTS ----- */
.dept-card {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(24,29,56,0.08);
    background: #fff;
    transition: transform 0.35s ease, box-shadow 0.35s ease;
    cursor: pointer;
}
.dept-card:hover { transform: translateY(-10px); box-shadow: 0 18px 40px rgba(24,29,56,0.16); }
.dept-card-img { height: 220px; overflow: hidden; position: relative; }
.dept-card-img img { width:100%; height:100%; object-fit:cover; transition: transform 0.55s ease; }
.dept-card:hover .dept-card-img img { transform: scale(1.1); }
.dept-card-img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(10,15,40,0.6) 0%, transparent 55%);
}
.dept-card-body {
    padding: 18px 22px 20px;
    border-top: 3px solid #D08301;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.dept-card-body h5 { margin:0; color:#181d38; font-weight:700; font-size:0.97rem; }
.dept-arrow {
    width: 32px; height: 32px; border-radius: 50%;
    background: #f4f9ff;
    display: flex; align-items: center; justify-content: center;
    color: #D08301;
    transition: background 0.3s, color 0.3s;
    flex-shrink: 0;
}
.dept-card:hover .dept-arrow { background: #D08301; color: #fff; }

/* ----- NEWS ----- */
.news-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(24,29,56,0.07);
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    border-top: 4px solid #D08301;
    transition: transform 0.32s ease, box-shadow 0.32s ease;
}
.news-card:hover { transform: translateY(-8px); box-shadow: 0 16px 40px rgba(24,29,56,0.14); }
.news-card-body { padding: 24px 26px; flex: 1; }
.news-date {
    font-size: 0.74rem; color: #D08301; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px;
}
.news-card-body h5 { color:#181d38; font-weight:700; font-size:1rem; margin-bottom:10px; line-height:1.4; }
.news-card-body p { color:#555; font-size:0.9rem; line-height:1.72; margin-bottom:0; }
.news-card-footer { padding: 0 26px 22px; }
.news-btn {
    background: #D08301; color: #fff; padding: 8px 22px;
    font-weight: 700; font-size: 0.82rem; border-radius: 4px;
    text-decoration: none; display: inline-block;
    transition: background 0.3s, transform 0.2s;
}
.news-btn:hover { background: #b36e00; color: #fff; transform: translateX(3px); }

/* ----- SERVICES ----- */
.services-section { background: #f4f7fc; }
.service-card {
    border-radius: 18px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 6px 24px rgba(24,29,56,0.1);
    cursor: pointer;
    display: block;
    text-decoration: none;
    transition: transform 0.38s ease, box-shadow 0.38s ease;
    height: 340px;
}
.service-card:hover { transform: translateY(-12px); box-shadow: 0 22px 50px rgba(24,29,56,0.18); }
.service-card-img {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center;
    transition: transform 0.55s ease;
}
.service-card:hover .service-card-img { transform: scale(1.08); }
.service-card-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(10,15,40,0.82) 0%, rgba(10,15,40,0.3) 55%, transparent 100%);
    transition: background 0.38s ease;
}
.service-card:hover .service-card-overlay {
    background: linear-gradient(to top, rgba(208,131,1,0.82) 0%, rgba(10,15,40,0.4) 55%, transparent 100%);
}
.service-card-content {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 28px 28px 26px;
}
.service-card-icon {
    width: 46px; height: 46px; border-radius: 12px;
    background: rgba(208,131,1,0.9);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px;
    transition: background 0.3s, transform 0.3s;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.service-card:hover .service-card-icon { background: #fff; transform: scale(1.1); }
.service-card:hover .service-card-icon i { color: #D08301 !important; }
.service-card-content h4 {
    color: #fff; font-weight: 700; font-size: 1.18rem; margin-bottom: 6px; line-height: 1.3;
}
.service-card-content p {
    color: rgba(255,255,255,0.82); font-size: 0.87rem; line-height: 1.6; margin-bottom: 14px;
}
.service-arrow-btn {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.4);
    color: #fff; font-size: 0.8rem; font-weight: 700;
    padding: 6px 16px; border-radius: 20px;
    transition: background 0.3s, border-color 0.3s;
    backdrop-filter: blur(4px);
}
.service-card:hover .service-arrow-btn { background: rgba(255,255,255,0.25); border-color: rgba(255,255,255,0.7); }

/* ----- TESTIMONIALS ----- */
.testimonial-item .testimonial-text {
    border-radius: 12px;
    margin-top: 8px;
}
</style>
@endpush

@section('content')

{{-- ===== HERO ===== --}}
<section class="hero-slider" id="heroSlider">
    <div class="hero-slide" style="background-image: url('{{ asset('img/University.jpg') }}')"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-9">
                    <h1 class="hero-title">
                        New Cairo University<br>of <span>Technology</span>
                    </h1>
                    <p class="hero-sub">{{ $siteSettings['tagline'] ?? 'Excellence in Technological Education' }}</p>
                    <div class="hero-divider"></div>
                    <a href="{{ route('about') }}" class="hero-btn">Read More <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== ABOUT ===== --}}
<section class="py-5 mt-1">
    <div class="container">
        <div class="row g-5 align-items-stretch">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                <div class="about-video-wrap">
                    <video controls>
                        <source src="{{ asset('img/videos/about1.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                <div class="about-text-card">
                    <span class="section-badge">About NCTU</span>
                    <h2 class="section-heading">Welcome to New Cairo<br>University of Technology</h2>
                    <div class="section-underline start mb-4"></div>
                    <p>New Cairo Technological University allocated 80% of its seats to technical diploma holders, focusing on bridging the gap between education and the job market.</p>
                    <p class="mb-4">The study period is four years (2+2), providing a professional bachelor's degree in technology across various modern specializations.</p>
                    <a href="{{ route('about') }}" class="hero-btn" style="animation:none;">Learn More <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== DEPARTMENTS ===== --}}
<section class="py-5" style="background:#f4f7fc;">
    <div class="container">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <span class="section-badge">Academic Programs</span>
            <h2 class="section-heading">Our Specialized Departments</h2>
            <div class="section-underline"></div>
        </div>
        @php
            $deptRouteMap = [
                'mechatronics'           => 'dept.mechatronics',
                'auto-tronics'           => 'dept.autotronics',
                'information-technology' => 'dept.ict',
                'petroleum'                => 'dept.petroleum',
                'renewable-energy'       => 'dept.renewable',
                'prosthetics'            => 'dept.prosthetics',
            ];
            // Fixed display names & images for Home Page cards (order matches DB order)
            $deptOverrides = [
                0 => ['label' => 'Mechatronics Technology',                'img' => 'img/Mecha.jpg'],
                1 => ['label' => 'Autotronics Technology',                 'img' => 'img/Auto.jpg'],
                2 => ['label' => 'Information and Communication Technology','img' => 'img/ICT.jpg'],
                3 => ['label' => 'Petroleum Technology',                   'img' => 'img/petrol.jpg'],
                4 => ['label' => 'New and Renewable Energy Technology',    'img' => 'img/Renew.jpg'],
                5 => ['label' => 'Prosthetics and Orthotics Technology',   'img' => 'img/Prosthetics.jpg'],
            ];
        @endphp
        <div class="row g-4 justify-content-center">
            @foreach($departments as $index => $dept)
            @php
                $targetUrl   = isset($deptRouteMap[$dept->slug]) ? route($deptRouteMap[$dept->slug]) : route('departments');
                $displayName = $deptOverrides[$index]['label'] ?? $dept->name;
                $displayImg  = $deptOverrides[$index]['img']   ?? null;
            @endphp
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index * 0.1) }}s">
                <a href="{{ $targetUrl }}" style="text-decoration:none;">
                    <div class="dept-card">
                        <div class="dept-card-img">
                            <img src="{{ asset($displayImg) }}" alt="{{ $displayName }}">
                            <div class="dept-card-img-overlay"></div>
                        </div>
                        <div class="dept-card-body">
                            <h5>{{ $displayName }}</h5>
                            <div class="dept-arrow">
                                <i class="bi bi-arrow-right" style="font-size:0.9rem;"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== LATEST NEWS ===== --}}
@if($latestNews->isNotEmpty())
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <span class="section-badge">What's New</span>
            <h2 class="section-heading">University Updates</h2>
            <div class="section-underline"></div>
        </div>
        <div class="row g-4">
            @foreach($latestNews as $newsItem)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="news-card">
                    <div class="news-card-body">
                        <p class="news-date">
                            <i class="fa fa-calendar-alt me-1"></i>
                            {{ $newsItem->published_at ? $newsItem->published_at->format('M d, Y') : $newsItem->created_at->format('M d, Y') }}
                        </p>
                        <h5>{{ $newsItem->title }}</h5>
                        <p>{{ Str::limit($newsItem->excerpt, 100) }}</p>
                    </div>
                    <div class="news-card-footer">
                        <a href="{{ route('news') }}" class="news-btn">Read More <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== OUR SERVICES (replaces Events) ===== --}}
<section class="py-5 services-section">
    <div class="container">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <span class="section-badge">What We Offer</span>
            <h2 class="section-heading">Our Services</h2>
            <div class="section-underline"></div>
        </div>
        <div class="row g-4 justify-content-center">

            {{-- Card 1: Student Activities --}}
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <a href="{{ route('activities') }}" class="service-card">
                    <div class="service-card-img" style="background-image:url('{{ asset('img/StudentActivities.jpg') }}')"></div>
                    <div class="service-card-overlay"></div>
                    <div class="service-card-content">
                        <div class="service-card-icon">
                            <i class="fa fa-users fa-lg text-white"></i>
                        </div>
                        <h4>Student Activities</h4>
                        <p>Explore clubs, competitions, cultural events, and extracurricular programs designed to enrich your university experience.</p>
                        <span class="service-arrow-btn">Explore <i class="bi bi-arrow-right"></i></span>
                    </div>
                </a>
            </div>

            {{-- Card 2: Postgraduate Studies --}}
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <a href="{{ route('postgraduate-studies') }}" class="service-card">
                    <div class="service-card-img" style="background-image:url('{{ asset('img/Postgraduate.jpg') }}')"></div>
                    <div class="service-card-overlay"></div>
                    <div class="service-card-content">
                        <div class="service-card-icon">
                            <i class="fa fa-graduation-cap fa-lg text-white"></i>
                        </div>
                        <h4>Postgraduate Studies</h4>
                        <p>Advance your career with our specialized postgraduate programs across technology and engineering disciplines.</p>
                        <span class="service-arrow-btn">Explore <i class="bi bi-arrow-right"></i></span>
                    </div>
                </a>
            </div>

            {{-- Card 3: Events --}}
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <a href="{{ route('events') }}" class="service-card">
                    <div class="service-card-img" style="background-image:url('{{ asset('img/events page.png') }}')"></div>
                    <div class="service-card-overlay"></div>
                    <div class="service-card-content">
                        <div class="service-card-icon">
                            <i class="fa fa-calendar-alt fa-lg text-white"></i>
                        </div>
                        <h4>Events</h4>
                        <p>Stay up to date with conferences, workshops, seminars, and university events happening throughout the year.</p>
                        <span class="service-arrow-btn">Explore <i class="bi bi-arrow-right"></i></span>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>

{{-- ===== TESTIMONIALS ===== --}}
<section class="py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Alumni Voices</span>
            <h2 class="section-heading">Success Stories from Our Alumni</h2>
            <div class="section-underline"></div>
        </div>
        <div class="owl-carousel testimonial-carousel position-relative">
            @forelse($testimonials as $testimonial)
                <div class="testimonial-item text-center">
                    @if($testimonial->photo)
                        <img class="border rounded-circle p-2 mx-auto mb-3" src="{{ asset('img/' . $testimonial->photo) }}" alt="{{ $testimonial->student_name }}" style="width:80px;height:80px;object-fit:cover;">
                    @else
                        <div class="border rounded-circle p-2 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px;background:#F4F9FF;">
                            <i class="fa fa-user-graduate fa-2x text-primary"></i>
                        </div>
                    @endif
                    @if($testimonial->department)
                        <h5 class="mb-0" style="color:#181d38;font-weight:700;">{{ $testimonial->department }}</h5>
                    @endif
                    <p style="color:#D08301;font-weight:600;margin-bottom:8px;">{{ $testimonial->student_name }}</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0" style="font-style:italic;color:#444;">{{ $testimonial->testimonial }}</p>
                    </div>
                </div>
            @empty
                <div class="testimonial-item text-center">
                    <div class="border rounded-circle p-2 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px;background:#F4F9FF;">
                        <i class="fa fa-user-graduate fa-2x text-primary"></i>
                    </div>
                    <h5 class="mb-0" style="color:#181d38;font-weight:700;">ICT Department</h5>
                    <p style="color:#D08301;font-weight:600;margin-bottom:8px;">Fatima (Tomi)</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0" style="font-style:italic;color:#444;">The practical training at NCTU helped me master Laravel and web development.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
