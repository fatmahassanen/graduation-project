@extends('layouts.app')

@section('title', 'Departments - New Cairo University of Technology')

@section('content')
<style>
    .read-more-btn {
        display: inline-block;
        background-color: #D08301;
        color: #fff;
        padding: 10px 10px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 15px;
        transition: all 0.3s ease;
    }

    .read-more-btn:hover {
        background-color: #b66f01;
        color: #fff;
        transform: scale(1.05);
    }

    /* Courses */
    .courses-container {
        display: flex;
        flex-direction: column;
        gap: 50px;
        margin: 50px 0;
    }

    .course {
        display: flex;
        flex-direction: row;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .course:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .course.course-reverse {
        flex-direction: row-reverse;
    }

    .course img {
        width: 50%;
        object-fit: cover;
    }

    .course-info {
        width: 50%;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .course-info h2 {
        color: #D08301;
        font-size: clamp(1.5rem, 3vw, 2rem);
        margin-bottom: 10px;
    }

    .course-info h6 {
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .course-info p {
        font-size: clamp(0.9rem, 1.2vw, 1rem);
        line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .course {
            flex-direction: column;
        }

        .course.course-reverse {
            flex-direction: column;
        }

        .course img,
        .course-info {
            width: 100%;
        }
    }
</style>

<!-- Courses -->
<div class="courses-container">
     <h1 class="text-primary">Faculty of Industrial and Energy Technology </h1>
    <!-- IT -->
    <div class="course course-reverse">
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
            <a href="{{ url('/information-technology') }}" class="read-more-btn">Read More</a>
        </div>
        <img src="{{ asset('img/Departments/information technology.jpg') }}" alt="Information Technology">
    </div>

    <!-- Mechatronics -->
    <div class="course">
        <img src="{{ asset('img/Departments/Mechatronic.jpg') }}" alt="Mechatronics Technology">
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
            <a href="{{ url('/mechatronics-technology') }}" class="read-more-btn">Read More</a>
        </div>
    </div>

    <!-- Auto-tronics -->
    <div class="course course-reverse">
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
            <a href="{{ url('/auto-tronics-technology') }}" class="read-more-btn">Read More</a>
        </div>
        <img src="{{ asset('img/Departments/Autotronics.jpg') }}" alt="Auto-tronics Technology">
    </div>

    <!-- Renewable -->
    <div class="course">
        <img src="{{ asset('img/Departments/Renewable energy.jpg') }}" alt="Renewable Energy Technology">
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
            <a href="{{ url('/renewable-energy-technology') }}" class="read-more-btn">Read More</a>
        </div>
    </div>

    <!-- Petroleum -->
    <div class="course course-reverse">
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
            <a href="{{ url('/petroleum-technology') }}" class="read-more-btn">Read More</a>
        </div>
        <img src="{{ asset('img/Departments/Petroleum engineering.jpg') }}" alt="Petroleum Technology">
    </div>
</div>
@endsection
