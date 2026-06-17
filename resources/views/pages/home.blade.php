@extends('layouts.app')

@section('title', 'New Cairo University of Technology - Home')

@section('content')
<div class="container-fluid p-0 mb-5">
    <div class="position-relative">
        <img class="img-fluid w-100" src="{{ asset('img/unvircity1.jpg') }}" alt="NCTU University">
        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
            <div class="container">
                <div class="row justify-content-start">
                    <div class="col-sm-10 col-lg-8">
                        <br><br><br>
                        <h1 class="text-white animated slideInDown" style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; letter-spacing: -0.5px; line-height: 1.2; margin-bottom: 1.5rem; text-shadow: 2px 4px 8px rgba(0,0,0,0.3);">
                            New Cairo University of Technology
                        </h1>
                        <p class="text-white mb-4 pb-2 animated slideInUp" style="font-size: clamp(1.1rem, 2.5vw, 1.4rem); font-weight: 400; letter-spacing: 0.3px; line-height: 1.6; opacity: 0.95; max-width: 600px;">
                            {{ $siteSettings['tagline'] ?? 'Excellence in Technological Education' }}
                        </p>
                        <a href="{{ route('about') }}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft" style="background: #D08301; border-color: #D08301;">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-title bg-white text-center text-orange px-3">About</h6>
            <h1>Welcome to New Cairo University of Technology</h1>
        </div>

        <div class="row g-4 align-items-stretch">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div style="background-color: #F4F9FF; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1); display: flex; justify-content: center; align-items: center; height: 100%;">
                    <video controls style="width:100%; height:auto; max-height:500px; object-fit: contain;">
                        <source src="{{ asset('img/videos/about1.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>

            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <div style="background-color: #F4F9FF; padding: 30px; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); height: 100%;">
                    <p class="mb-4">New Cairo Technological University allocated 80% of its seats to technical diploma holders, focusing on bridging the gap between education and the job market.</p>
                    <p class="mb-4">The study period is four years (2+2), providing a professional bachelor's degree in technology across various modern specializations.</p>
                    <a href="{{ route('about') }}" class="btn btn-primary py-3 px-5" style="background: #D08301; border-color: #D08301;">Read More</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-orange px-3">Departments</h6>
            <h1 class="mb-5">Our Specialized Departments</h1>
        </div>
        <div class="row g-4 justify-content-center">
            @php
                $defaultImages = ['mecha.jpeg', 'auto.jpeg', 'info.jpeg', 'petro.jpeg', 'renew.jpeg', 'prothetic.jpeg'];
            @endphp
            @foreach($departments as $index => $dept)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index * 0.1) }}s">
                <a href="{{ route('departments') }}#dept-{{ $dept->id }}" style="text-decoration: none;">
                    <div class="course-item bg-light">
                        <div class="img-container" style="height: 230px; overflow: hidden;">
                            @if($dept->image)
                                <img src="{{ asset($dept->image) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $dept->name }}">
                            @else
                                <img src="{{ asset('img/index/' . ($defaultImages[$index] ?? 'info.jpeg')) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $dept->name }}">
                            @endif
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">{{ $dept->name }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@if($latestNews->isNotEmpty())
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-orange px-3">Latest News</h6>
            <h1 class="mb-5">University Updates</h1>
        </div>
        <div class="row g-4">
            @foreach($latestNews as $newsItem)
            <div class="col-lg-4 col-md-6 wow fadeInUp">
                <div class="course-item bg-light p-4">
                    <h5 class="mb-3">{{ $newsItem->title }}</h5>
                    <p class="small text-muted"><i class="fa fa-calendar-alt me-2"></i>{{ $newsItem->published_at ? $newsItem->published_at->format('M d, Y') : $newsItem->created_at->format('M d, Y') }}</p>
                    <p>{{ Str::limit($newsItem->excerpt, 90) }}</p>
                    <a href="{{ route('news') }}" class="btn btn-sm btn-primary" style="background: #D08301; border-color: #D08301;">Read More</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($latestEvents->isNotEmpty())
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-orange px-3">Events</h6>
            <h1 class="mb-5">Upcoming Activities</h1>
        </div>
        <div class="row g-4">
            @foreach($latestEvents as $event)
            <div class="col-lg-4 col-md-6 wow fadeInUp">
                <div class="event-category-card" style="border-top: 4px solid #D08301; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div class="mb-3 text-center">
                        <img src="{{ asset($event->image) }}" class="rounded" style="width: 100%; height: 180px; object-fit: cover;" onerror="this.src='{{ asset('img/Events/Conferences.jpg') }}'">
                    </div>
                    <h4 class="text-center">{{ Str::limit($event->title, 25) }}</h4>
                    <p class="text-center small text-primary fw-bold">{{ $event->created_at->format('d M, Y') }}</p>
                    <p class="text-center">{{ Str::limit($event->description, 80) }}</p>
                    <div class="text-center">
                        <a href="{{ $event->link }}" class="btn btn-sm text-white" style="background: #D08301; border-radius: 20px; padding: 5px 20px;">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center">
            <h6 class="section-title bg-white text-center text-orange px-3">Testimonials</h6>
            <h1 class="mb-5">Success Stories from Our Alumni</h1>
        </div>
        <div class="owl-carousel testimonial-carousel position-relative">
            @forelse($testimonials as $testimonial)
                <div class="testimonial-item text-center">
                    @if($testimonial->photo)
                        <img class="border rounded-circle p-2 mx-auto mb-3" src="{{ asset('img/' . $testimonial->photo) }}" alt="{{ $testimonial->student_name }}" style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="testimonial-icon-wrap border rounded-circle p-2 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fa fa-user-graduate fa-2x text-primary"></i>
                        </div>
                    @endif
                    @if($testimonial->department)
                        <h5 class="mb-0">{{ $testimonial->department }}</h5>
                    @endif
                    <p>{{ $testimonial->student_name }}</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">{{ $testimonial->testimonial }}</p>
                    </div>
                </div>
            @empty
                <div class="testimonial-item text-center">
                    <div class="testimonial-icon-wrap border rounded-circle p-2 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fa fa-user-graduate fa-2x text-primary"></i>
                    </div>
                    <h5 class="mb-0">ICT Department</h5>
                    <p>Fatima (Tomi)</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">The practical training at NCTU helped me master Laravel and web development.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
