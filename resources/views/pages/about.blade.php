@extends('layouts.app')

@section('title', 'About Us - New Cairo University of Technology')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">About Us</h1>
                <nav aria-label="breadcrumb">
                    <!-- Breadcrumb can be added here if needed -->
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Hero Video Card Start -->
<div class="container mt-5 position-relative">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden wow fadeInUp" data-wow-delay="0.2s">
        <video class="w-100" autoplay muted loop controls style="max-height: 420px; object-fit: cover;">
            <source src="{{ asset('img/videos/aboutNUCT.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</div>
<!-- Hero Video Card End -->

<!-- Service Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <h5 class="mb-3" id="content">Our Core Values</h5>
                        <p>Our holistic approach to education, the rigorous spirit of inquiry that makes our community and alumni a force for change in the world, and our commitment to social justice ground</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <h5 class="mb-3">Our Mission</h5>
                        <p>New Cairo University educates women and men to be reflective lifelong learners, to be responsible and active participants in civic life and to live generously in service to others.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <h5 class="mb-3">We Are Cairo University</h5>
                        <p>We're a community of people who bridge our disparate experiences and identities. Meet the unsung heroes, beloved figures and dedicated members who make Cairo University special.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <h5 class="mb-3">New Cairo University</h5>
                        <p>is a modern institution offering quality education and global collaborations. With advanced facilities it prepares students for future success in a dynamic learning environment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->

<!-- Who Are We Section -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center" style="color: #D08301; display: inline-block; padding: 0 10px;">New Cairo University</h6>
            <h1 class="mb-5" style="color: #1a096e;">Who Are We</h1>
        </div>

        <div class="shadow-lg p-4 rounded-4" style="max-width: 900px; margin:auto; border-left: 6px solid #D08301; background-color: #fff;">
            <p style="color: #333; line-height: 1.8; font-size: 1.1rem;">
                "New Cairo Technological University is a pioneering institution at the forefront of applied sciences and modern technology.
                Established to bridge the gap between academia and industry, NCTU equips students with cutting-edge skills and hands-on
                experience in various high-tech fields. With a forward-thinking curriculum and strong industry partnerships,
                the university prepares the next generation of innovators and problem-solvers to lead the future."
            </p>
        </div>
    </div>
</div>

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                <div class="position-relative h-100">
                    <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('img/faq.png') }}" alt="" style="object-fit: cover;">
                </div>
            </div>
            <!-- FAQ Section -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="faq-section">
                    <h2>The most important questions</h2>
                    <div class="faq">
                        @foreach($faqSections as $faq)
                            <div class="faq-item" onclick="toggleAnswer(this)">
                                <span>{{ $faq->section_title }}</span>
                            </div>
                            <div class="answer">
                                {!! $faq->section_content !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->
@endsection
