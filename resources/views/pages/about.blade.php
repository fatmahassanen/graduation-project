@extends('layouts.app')

@section('title', 'About Us - New Cairo University of Technology')

@push('styles')
<style>
/* ===== ABOUT PAGE ===== */

/* Page Header */
.about-page-header {
    background: linear-gradient(rgba(10,15,40,0.78), rgba(10,15,40,0.78)),
                url('{{ asset('img/univercty2.jpg') }}') center/cover no-repeat;
    padding: 100px 0 70px;
}
.about-page-header h1 {
    font-size: clamp(2rem, 5vw, 3.2rem);
    font-weight: 800;
    color: #fff;
    text-align: center;
    letter-spacing: -0.5px;
}
.about-breadcrumb {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 14px;
    font-size: 0.9rem;
    color: rgba(255,255,255,0.7);
}
.about-breadcrumb span { color: #D08301; font-weight: 600; }

/* Section label */
.about-label {
    display: inline-block;
    color: #D08301;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.about-title {
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 800;
    color: #181d38;
    line-height: 1.2;
    margin-bottom: 0;
}
.about-divider {
    width: 50px; height: 3px;
    background: #D08301;
    border-radius: 2px;
    margin: 14px auto 0;
}
.about-divider.left { margin-left: 0; }

/* Value cards */
.value-card {
    background: #fff;
    border-radius: 18px;
    padding: 36px 28px;
    box-shadow: 0 4px 22px rgba(24,29,56,0.07);
    height: 100%;
    transition: transform 0.32s ease, box-shadow 0.32s ease;
    border-bottom: 3px solid transparent;
    text-align: center;
}
.value-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 40px rgba(24,29,56,0.13);
    border-bottom-color: #D08301;
}
.value-icon {
    width: 64px; height: 64px;
    border-radius: 16px;
    background: linear-gradient(135deg, #D08301, #f0a030);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 6px 18px rgba(208,131,1,0.3);
}
.value-icon i { color: #fff; font-size: 1.4rem; }
.value-card h5 {
    font-weight: 700; color: #181d38;
    font-size: 1.05rem; margin-bottom: 12px;
}
.value-card p { color: #555; font-size: 0.92rem; line-height: 1.75; margin: 0; }

/* Who are we */
.who-card {
    background: #fff;
    border-radius: 20px;
    padding: 44px 48px;
    border-left: 6px solid #D08301;
    box-shadow: 0 8px 32px rgba(24,29,56,0.08);
    position: relative;
    overflow: hidden;
}
.who-card::after {
    content: '\201C';
    position: absolute;
    top: -20px; right: 30px;
    font-size: 12rem;
    color: rgba(208,131,1,0.07);
    font-family: Georgia, serif;
    line-height: 1;
    pointer-events: none;
}
.who-card p {
    font-size: 1.08rem;
    line-height: 1.9;
    color: #333;
    margin: 0;
    font-style: italic;
}

/* FAQ section */
.faq-image-wrap {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 36px rgba(24,29,56,0.13);
    height: 100%;
    min-height: 380px;
}
.faq-image-wrap img { width:100%; height:100%; object-fit:cover; display:block; }

.faq-item-modern {
    background: #fff;
    border-radius: 12px;
    padding: 16px 22px;
    margin-bottom: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    box-shadow: 0 2px 12px rgba(24,29,56,0.06);
    border-left: 4px solid #D08301;
    transition: background 0.25s, box-shadow 0.25s, transform 0.25s;
    font-weight: 600;
    color: #181d38;
    font-size: 0.95rem;
}
.faq-item-modern:hover {
    background: #D08301;
    color: #fff;
    transform: translateX(4px);
    box-shadow: 0 6px 20px rgba(208,131,1,0.25);
}
.faq-item-modern .faq-chevron {
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(208,131,1,0.12);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: background 0.25s, transform 0.25s;
}
.faq-item-modern:hover .faq-chevron { background: rgba(255,255,255,0.25); }
.faq-item-modern.open .faq-chevron { transform: rotate(180deg); }

.answer-modern {
    display: none;
    background: #f8faff;
    border-radius: 10px;
    padding: 16px 20px;
    margin-top: -8px;
    margin-bottom: 12px;
    font-size: 0.9rem;
    color: #444;
    line-height: 1.75;
    border-left: 4px solid rgba(208,131,1,0.3);
}
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="about-page-header">
    <div class="container">
        <h1 class="animated slideInDown">{{ __('messages.about_us') }}</h1>
        <div class="about-breadcrumb">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.7);text-decoration:none;">Home</a>
            <i class="bi bi-chevron-right" style="font-size:0.75rem;margin-top:2px;"></i>
            <span>About Us</span>
        </div>
    </div>
</div>

{{-- HERO VIDEO --}}
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 wow fadeInUp" data-wow-delay="0.1s">
                <div style="border-radius:20px;overflow:hidden;box-shadow:0 12px 40px rgba(24,29,56,0.14);">
                    <video class="w-100" autoplay muted loop controls style="max-height:440px;object-fit:cover;display:block;">
                        <source src="{{ url('https://nctu.site/img/aboutNUCT.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- VALUE CARDS --}}
<section class="py-5" style="background:#f4f7fc;">
    <div class="container">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <span class="about-label">What We Stand For</span>
            <h2 class="about-title">Our Core Pillars</h2>
            <div class="about-divider"></div>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="value-card">
                    <div class="value-icon"><i class="fa fa-star"></i></div>
                    <h5>Our Core Values</h5>
                    <p>Our holistic approach to education, the rigorous spirit of inquiry that makes our community and alumni a force for change in the world, and our commitment to social justice ground</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="value-card">
                    <div class="value-icon"><i class="fa fa-bullseye"></i></div>
                    <h5>Our Mission</h5>
                    <p>New Cairo University educates women and men to be reflective lifelong learners, to be responsible and active participants in civic life and to live generously in service to others.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="value-card">
                    <div class="value-icon"><i class="fa fa-university"></i></div>
                    <h5>We Are Cairo University</h5>
                    <p>We're a community of people who bridge our disparate experiences and identities. Meet the unsung heroes, beloved figures and dedicated members who make Cairo University special.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="value-card">
                    <div class="value-icon"><i class="fa fa-lightbulb"></i></div>
                    <h5>New Cairo University</h5>
                    <p>is a modern institution offering quality education and global collaborations. With advanced facilities it prepares students for future success in a dynamic learning environment.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- WHO ARE WE --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <span class="about-label">New Cairo University</span>
            <h2 class="about-title">Who Are We</h2>
            <div class="about-divider"></div>
        </div>
        <div class="row justify-content-center wow fadeInUp" data-wow-delay="0.2s">
            <div class="col-lg-9">
                <div class="who-card">
                    <p>"New Cairo Technological University is a pioneering institution at the forefront of applied sciences and modern technology.
                    Established to bridge the gap between academia and industry, NCTU equips students with cutting-edge skills and hands-on
                    experience in various high-tech fields. With a forward-thinking curriculum and strong industry partnerships,
                    the university prepares the next generation of innovators and problem-solvers to lead the future."</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="py-5" style="background:#f4f7fc;">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.1s">
                <div class="faq-image-wrap">
                    <img src="{{ asset('img/faq.png') }}" alt="FAQ">
                </div>
            </div>
            <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.2s">
                <span class="about-label">Common Questions</span>
                <h2 class="about-title mb-2">The Most Important Questions</h2>
                <div class="about-divider left mb-4"></div>
                <div class="faq-modern">
                    @foreach($faqSections as $faq)
                        <div class="faq-item-modern" onclick="toggleFaq(this)">
                            <span>{{ $faq->section_title }}</span>
                            <div class="faq-chevron"><i class="bi bi-chevron-down" style="font-size:0.8rem;"></i></div>
                        </div>
                        <div class="answer-modern">
                            {!! $faq->section_content !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function toggleFaq(el) {
    var answer = el.nextElementSibling;
    var allAnswers = document.querySelectorAll('.answer-modern');
    var allItems   = document.querySelectorAll('.faq-item-modern');
    allAnswers.forEach(function(a) {
        if (a !== answer) { a.style.display = 'none'; }
    });
    allItems.forEach(function(i) {
        if (i !== el) { i.classList.remove('open'); }
    });
    if (answer.style.display === 'block') {
        answer.style.display = 'none';
        el.classList.remove('open');
    } else {
        answer.style.display = 'block';
        el.classList.add('open');
    }
}
</script>
@endpush
