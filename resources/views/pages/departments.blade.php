@extends('layouts.app')

@section('title', 'Departments - New Cairo University of Technology')

@push('styles')
<style>
    .dept-page { background: #f4f7fc; padding: 20px 0 60px; }
    .dept-faculty-title {
        font-size: 1.4rem; font-weight: 800; color: #1a096e;
        border-left: 5px solid #D08301; padding-left: 14px;
        margin: 40px 0 30px;
    }
    .courses-container { display: flex; flex-direction: column; gap: 36px; margin-bottom: 60px; }
    .course {
        display: flex; flex-direction: row; align-items: stretch;
        background: #fff; border-radius: 18px;
        box-shadow: 0 6px 24px rgba(24,29,56,0.08);
        overflow: hidden;
        border-top: 4px solid #D08301;
        transition: transform 0.32s ease, box-shadow 0.32s ease;
    }
    .course:hover { transform: translateY(-6px); box-shadow: 0 16px 44px rgba(24,29,56,0.14); }
    .course.course-reverse { flex-direction: row-reverse; }
    .course img { width: 45%; min-height: 280px; object-fit: cover; display: block; transition: transform 0.5s ease; flex-shrink: 0; }
    .course:hover img { transform: scale(1.04); }
    .course-info {
        width: 55%; padding: 36px 40px;
        display: flex; flex-direction: column; justify-content: center;
    }
    .course-info h2 {
        color: #1a096e; font-size: clamp(1.3rem, 2.5vw, 1.7rem);
        font-weight: 800; margin-bottom: 6px;
        border-left: 4px solid #D08301; padding-left: 12px;
    }
    .course-info p { font-size: 0.93rem; line-height: 1.75; color: #444; margin-bottom: 6px; }
    .course-info h6 { font-weight: 700; color: #181d38; margin-top: 10px; margin-bottom: 4px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .course-info hr { border-color: #f0f0f0; margin: 8px 0; }
    .read-more-btn {
        display: inline-flex; align-items: center; gap: 6px;
        background: #D08301; color: #fff;
        padding: 10px 22px; border-radius: 6px;
        text-decoration: none; font-weight: 700; font-size: 0.85rem;
        margin-top: 18px; transition: background 0.3s, transform 0.2s;
        align-self: flex-start;
    }
    .read-more-btn:hover { background: #b36e00; color: #fff; transform: translateX(4px); }
    @media (max-width: 992px) {
        .course, .course.course-reverse { flex-direction: column; }
        .course img { width: 100%; height: 260px; min-height: unset; }
        .course-info { width: 100%; padding: 28px; }
    }
</style>
@endpush

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Departments</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Departments</li>
            </ol>
        </nav>
    </div>
</div>

<div class="dept-page">
    <div class="container">
        <h2 class="dept-faculty-title">Faculty of Industrial and Energy Technology</h2>

        <div class="courses-container">
            <!-- IT -->
            <div class="course wow fadeInUp" data-wow-delay="0.1s">
                <img src="{{ asset('img/ICT.jpg') }}" alt="Information Technology">
                <div class="course-info" id="specific-section">
                    <h2 class="text-primary">Information Technology</h2>
                    <p><strong>Department – New Cairo Technological University (NCTU)</strong></p>
                    <h6>Overview</h6>
                    <p>The (Information Technology (IT) Department) at (NCTU) equips students with essential skills in
                        computing and information systems, focusing on practical training and real-world applications.</p>
                    <hr>
                    <h6>Specializations</h6>
                    <p>💻 Networks & cybersecurity, 💻 Software development</p>
                    <hr>
                    <h6>Career Opportunities</h6>
                    <p>🖥 Software Developer, 🔒 Cybersecurity Analyst, 🌐 Network Engineer, 📊 Database Administrator, 🤖
                        AI & Machine Learning Engineer</p>
                    <a href="{{ route('dept.ict') }}" class="read-more-btn">Read More</a>
                </div>
            </div>

            <!-- Mechatronics -->
            <div class="course wow fadeInUp" data-wow-delay="0.1s">
                <img src="{{ asset('img/Mecha.jpg') }}" alt="Mechatronics Technology">
                <div class="course-info" id="specific-section1">
                    <h2 class="text-primary">Mechatronics Technology</h2>
                    <p><strong>Department – New Cairo Technological University (NCTU)</strong></p>
                    <h6>Overview</h6>
                    <p>The (Mechatronics Technology Department) at (NCTU) provides students with a multidisciplinary
                        education in mechanical, electrical, and computer engineering, preparing them for careers in
                        automation, robotics, and smart manufacturing.</p>
                    <hr>
                    <h6>Specializations</h6>
                    <p>⚙️ Automation & Robotics, ⚙️ Mechanical & Electrical Systems</p>
                    <hr>
                    <h6>Career Opportunities</h6>
                    <p>⚙️ Automation Engineer, 🤖 Robotics Engineer, 🔋 Mechatronics Systems Designer</p>
                    <a href="{{ route('dept.mechatronics') }}" class="read-more-btn">Read More</a>
                </div>
            </div>

            <!-- Auto-tronics -->
            <div class="course course-reverse wow fadeInUp" data-wow-delay="0.1s">
                <img src="{{ asset('img/Auto.jpg') }}" alt="Auto-tronics Technology">
                <div class="course-info" id="specific-section2">
                    <h2 class="text-primary">Auto-tronics Technology</h2>
                    <p><strong>Department – New Cairo Technological University (NCTU)</strong></p>
                    <h6>Overview</h6>
                    <p>The (Autotronics Technology Department) at (NCTU) focuses on the integration of electronics,
                        automation, and mechanics in modern automotive systems. The program prepares students for careers in
                        smart vehicle technology, electric and hybrid cars, and advanced automotive diagnostics.</p>
                    <hr>
                    <h6>Specializations</h6>
                    <p>🚗 Electric & Hybrid Vehicles, 🚗 Automotive Electronics & Diagnostics, 🚗 Automotive Mechatronics
                    </p>
                    <hr>
                    <h6>Career Opportunities</h6>
                    <p>🚗 Automotive Engineer, ⚙️ Vehicle Diagnostics Specialist, 🔋 Electric & Hybrid Vehicle Technician,
                        🏭 Manufacturing & Production Engineer, 💡 Embedded Systems Engineer</p>
                    <a href="{{ route('dept.autotronics') }}" class="read-more-btn">Read More</a>
                </div>
            </div>

            <!-- Renewable -->
            <div class="course wow fadeInUp" data-wow-delay="0.1s">
                <img src="{{ asset('img/Renew.jpg') }}" alt="Renewable Energy Technology">
                <div class="course-info" id="specific-section3">
                    <h2 class="text-primary">Renewable Energy Technology</h2>
                    <p><strong>Department – New Cairo Technological University (NCTU)</strong></p>
                    <h6>Overview</h6>
                    <p>The (Renewable Energy Technology Department) at (NCTU) focuses on sustainable energy solutions,
                        including solar, wind, and energy storage systems. The program prepares students for careers in the
                        green energy sector, power management, and smart grid technology.</p>
                    <hr>
                    <h6>Specializations</h6>
                    <p>☀️ Solar Energy Systems, 💨 Wind Energy, 🔋 Energy Storage & Smart Grids</p>
                    <hr>
                    <h6>Career Opportunities</h6>
                    <p>⚡ Renewable Energy Engineer, ☀️ Solar Power System Designer, 💨 Wind Energy Specialist, 🔋 Energy
                        Storage & Battery Engineer, 🌍 Smart Grid & Sustainability Consultant</p>
                    <a href="{{ route('dept.renewable') }}" class="read-more-btn">Read More</a>
                </div>
            </div>

            <!-- Petroleum -->
            <div class="course course-reverse wow fadeInUp" data-wow-delay="0.1s">
                <img src="{{ asset('img/petrol.jpg') }}" alt="Petroleum Technology">
                <div class="course-info" id="specific-section4">
                    <h2 class="text-primary">Petroleum Technology</h2>
                    <p><strong>Department – New Cairo Technological University (NCTU)</strong></p>
                    <h6>Overview</h6>
                    <p>The (Petroleum Technology Department) at (NCTU) focuses on the exploration, extraction, and refining
                        of oil and gas. The program equips students with the skills needed in drilling, reservoir
                        engineering, and petroleum processing, preparing them for careers in the energy sector.</p>
                    <hr>
                    <h6>Specializations</h6>
                    <p>🛢️ Drilling & Exploration, ⚙️ Reservoir Engineering, 🏭 Petroleum Refining & Processing</p>
                    <hr>
                    <h6>Career Opportunities</h6>
                    <p>⛽ Petroleum Engineer, 🛢️ Drilling & Production Engineer, ⚙️ Reservoir Engineer, 🏭 Refinery &
                        Process Engineer, 🌍 Energy & Environmental Consultant</p>
                    <a href="{{ route('dept.petroleum') }}" class="read-more-btn">Read More</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
