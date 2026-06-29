@extends('layouts.app')

@section('title', 'Contact Us - New Cairo University of Technology')

@push('styles')
<style>
/* ===== CONTACT PAGE ===== */
.contact-header {
    background: linear-gradient(rgba(10,15,40,0.80), rgba(10,15,40,0.80)),
                url('{{ asset('img/univercty2.jpg') }}') center/cover no-repeat;
    padding: 100px 0 70px;
    text-align: center;
}
.contact-header h1 {
    font-size: clamp(2rem, 5vw, 3.2rem);
    font-weight: 800; color: #fff; margin: 0;
}
.contact-breadcrumb {
    display: flex; justify-content: center;
    gap: 8px; margin-top: 14px;
    font-size: 0.9rem; color: rgba(255,255,255,0.7);
}
.contact-breadcrumb span { color: #D08301; font-weight: 600; }
.contact-breadcrumb a  { color: rgba(255,255,255,0.7); text-decoration: none; }

/* Section label */
.c-label {
    display: inline-block; color: #D08301;
    font-size: 0.72rem; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; margin-bottom: 8px;
}
.c-title {
    font-size: clamp(1.7rem, 3vw, 2.2rem);
    font-weight: 800; color: #181d38; margin-bottom: 0;
}
.c-divider {
    width: 50px; height: 3px; background: #D08301;
    border-radius: 2px; margin: 14px auto 0;
}

/* Info cards */
.contact-info-card {
    background: #fff;
    border-radius: 18px;
    padding: 36px 32px;
    box-shadow: 0 4px 22px rgba(24,29,56,0.07);
    height: 100%;
}
.contact-info-card .intro-text {
    font-size: 0.95rem; color: #555;
    line-height: 1.8; margin-bottom: 28px;
    padding-bottom: 24px;
    border-bottom: 1px solid #f0f0f0;
}

/* Info item */
.c-info-item {
    display: flex; align-items: flex-start;
    gap: 16px; margin-bottom: 20px;
}
.c-info-icon {
    width: 48px; height: 48px; border-radius: 12px;
    background: linear-gradient(135deg, #1a3a6e, #2356c7);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(30,60,114,0.25);
}
.c-info-icon i { color: #fff; font-size: 1rem; }
.c-info-text h6 {
    font-size: 0.72rem; font-weight: 700; color: #D08301;
    text-transform: uppercase; letter-spacing: 1.5px;
    margin: 0 0 4px;
}
.c-info-text p, .c-info-text a {
    font-size: 0.9rem; color: #333;
    margin: 0; text-decoration: none;
    word-break: break-all;
    transition: color 0.2s;
}
.c-info-text a:hover { color: #D08301; }

/* Social links */
.c-social { display: flex; gap: 10px; margin-top: 8px; }
.c-social-btn {
    width: 38px; height: 38px; border-radius: 10px;
    background: #f4f7fc;
    display: flex; align-items: center; justify-content: center;
    color: #1a3a6e; font-size: 0.95rem;
    text-decoration: none;
    transition: background 0.3s, color 0.3s, transform 0.2s;
}
.c-social-btn:hover {
    background: #D08301; color: #fff; transform: translateY(-3px);
}

/* Map card */
.map-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 4px 22px rgba(24,29,56,0.07);
    height: 100%;
    min-height: 420px;
    display: flex; flex-direction: column;
}
.map-card-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid #f0f0f0;
}
.map-card-header h5 {
    font-weight: 700; color: #181d38; margin: 0; font-size: 1rem;
}
.map-card iframe {
    flex: 1; border: 0; display: block; min-height: 360px;
}

/* Reach out section */
.reach-card {
    background: linear-gradient(135deg, #1a3a6e 0%, #2356c7 100%);
    border-radius: 18px;
    padding: 50px 40px;
    color: #fff;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.reach-card::before {
    content: ''; position: absolute;
    top: -60px; right: -60px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
}
.reach-card::after {
    content: ''; position: absolute;
    bottom: -40px; left: -40px;
    width: 150px; height: 150px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}
.reach-card h3 { font-weight: 800; font-size: 1.5rem; margin-bottom: 12px; }
.reach-card p  { color: rgba(255,255,255,0.82); font-size: 0.95rem; margin-bottom: 24px; }
.reach-email-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: #D08301; color: #fff;
    padding: 12px 28px; border-radius: 8px;
    font-weight: 700; font-size: 0.9rem;
    text-decoration: none;
    transition: background 0.3s, transform 0.2s;
    position: relative; z-index: 1;
}
.reach-email-btn:hover { background: #b36e00; color: #fff; transform: translateY(-2px); }
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="contact-header">
    <div class="container">
        <h1 class="animated slideInDown">Contact Us</h1>
        <div class="contact-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="bi bi-chevron-right" style="font-size:0.75rem;margin-top:2px;"></i>
            <span>Contact</span>
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<section class="py-5" style="background:#f4f7fc;">
    <div class="container">

        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <span class="c-label">Get In Touch</span>
            <h2 class="c-title">Contact us for any inquiries</h2>
            <div class="c-divider"></div>
        </div>

        <div class="row g-4 mb-4">

            {{-- INFO CARD --}}
            <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.1s">
                <div class="contact-info-card">
                    <p class="intro-text">
                        "This website helps you easily access the Technology College at Cairo University.
                        Here, you will find information about the location, available majors, latest news, and events.
                        Discover more about our academic programs, training opportunities, and how to enroll."
                    </p>

                    {{-- Address --}}
                    <div class="c-info-item">
                        <div class="c-info-icon"><i class="fa fa-map-marker-alt"></i></div>
                        <div class="c-info-text">
                            <h6>Office</h6>
                            <a href="https://www.google.com/maps/search/%D8%AC%D8%A7%D9%85%D8%B9%D9%87+%D8%A7%D9%84%D9%82%D8%A7%D9%87%D8%B1%D9%87+%D8%A7%D9%84%D8%AC%D8%AF%D9%8A%D8%AF%D9%87+%D8%A7%D9%84%D8%AA%D9%83%D9%86%D9%88%D9%84%D9%88%D8%AC%D9%8A%D8%A7%E2%80%AD%E2%80%AD/@30.022714,31.5229726,17z" target="_blank">
                                <p>New Cairo Technological University, Egypt</p>
                            </a>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="c-info-item">
                        <div class="c-info-icon"><i class="fa fa-phone-alt"></i></div>
                        <div class="c-info-text">
                            <h6>Mobile Phone</h6>
                            <a href="tel:+201111335725"><p>+20 111 133 5725</p></a>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="c-info-item">
                        <div class="c-info-icon"><i class="fa fa-envelope"></i></div>
                        <div class="c-info-text">
                            <h6>Email</h6>
                            <a href="mailto:info@nctu.edu.eg"><p>info@nctu.edu.eg</p></a>
                        </div>
                    </div>

                    {{-- Website --}}
                    <div class="c-info-item">
                        <div class="c-info-icon"><i class="fa fa-globe"></i></div>
                        <div class="c-info-text">
                            <h6>Website</h6>
                            <a href="https://nctu.edu.eg" target="_blank"><p>nctu.edu.eg</p></a>
                        </div>
                    </div>

                    {{-- Social --}}
                    <div class="c-info-item">
                        <div class="c-info-icon"><i class="fa fa-share-alt"></i></div>
                        <div class="c-info-text">
                            <h6>Social Media</h6>
                            <div class="c-social mt-2">
                                <a href="https://www.facebook.com/nctu.edu.eg" target="_blank" class="c-social-btn" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://www.linkedin.com/school/nct-uni/" target="_blank" class="c-social-btn" title="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://www.youtube.com/@NCTU_egypt" target="_blank" class="c-social-btn" title="YouTube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                <a href="https://twitter.com/nctu_egypt" target="_blank" class="c-social-btn" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- MAP CARD --}}
            <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.2s">
                <div class="map-card">
                    <div class="map-card-header">
                        <h5><i class="fa fa-map-marker-alt me-2" style="color:#D08301;"></i>Find Us on the Map</h5>
                    </div>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3454.830518741768!2d31.499282575292457!3d30.020992775020803!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583d865c8c5c77%3A0x961e6b8d4a67a2e4!2sNew%20Cairo%20University%20of%20Technology!5e0!3m2!1sen!2seg!4v1710000000000!5m2!1sen!2seg"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        aria-label="NCTU Location Map">
                    </iframe>
                </div>
            </div>

        </div>

        {{-- REACH OUT BANNER --}}
        <div class="row wow fadeInUp" data-wow-delay="0.2s">
            <div class="col-12">
                <div class="reach-card">
                    <h3>Still have questions?</h3>
                    <p>Our team is happy to help. Send us an email and we'll get back to you as soon as possible.</p>
                    <a href="mailto:info@nctu.edu.eg" class="reach-email-btn">
                        <i class="fa fa-envelope"></i> Send us an Email
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
