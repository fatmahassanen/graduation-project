@extends('layouts.app')

@section('title', 'Campus Tour - New Cairo University of Technology')

@section('content')
<style>
    .img-container {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        height: 220px;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .img-container:hover img {
        transform: scale(1.08);
    }

    .img-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 48px;
    }

    .img-placeholder i {
        color: #D08301;
        margin-bottom: 10px;
    }

    .img-placeholder span {
        font-size: 14px;
        color: #64748b;
    }

    .building-img, .workshop-img {
        max-width: 100%;
        height: auto;
        border-radius: 15px;
        object-fit: cover;
    }

    .floor-card {
        margin-bottom: 15px;
    }

    .floor-card button, .floor-btn {
        background: #1a096e;
        color: #fff;
        border: none;
        padding: 12px 20px;
        width: 100%;
        text-align: left;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.3s ease;
    }

    .floor-card button:hover, .floor-btn:hover {
        background: #D08301;
    }

    .details-card, .details-workshop {
        display: none;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
    }

    .building-title, .workshop-title {
        color: #1a096e;
        font-weight: bold;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .img-container {
            height: 180px;
        }
    }
</style>

<x-page-header :title="__('messages.campus_tour')" />

<!-- <div class="container mt-5 position-relative">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden wow fadeInUp" data-wow-delay="0.2s">
        @if(file_exists(public_path('img/videos/Campus Tour.mp4')))
            <video class="w-100" autoplay muted loop controls style="max-height: 420px; object-fit: cover;">
                <source src="{{ asset('img/videos/Campus Tour.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @else
            <div style="height: 420px; background: linear-gradient(135deg, #1a096e 0%, #0d0438 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px;">
                <div class="text-center">
                    <i class="fas fa-video fa-3x mb-3" style="color: #D08301;"></i>
                    <p>Campus Tour Video</p>
                </div>
            </div>
        @endif
    </div>
</div> -->

<br><br><br>

<div class="container my-5">
    <div class="row g-3">
        @php
        $campusImages = [
            ['path' => 'Campus1.jpeg', 'alt' => 'University Building'],
            ['path' => 'Campus2.jpeg', 'alt' => 'Stadium'],
            ['path' => 'Campus3.jpeg', 'alt' => 'Academic Building'],
            ['path' => 'Campus4.jpeg', 'alt' => 'Gym'],
            ['path' => 'Campus5.jpeg', 'alt' => 'Library'],
            ['path' => 'Campus6.jpeg', 'alt' => 'Lecture Hall'],
            ['path' => 'univercty2.jpg', 'alt' => 'Classroom'],
            ['path' => 'unvircity1.jpg', 'alt' => 'Computer Lab'],
        ];
        @endphp

        @foreach($campusImages as $image)
        <div class="col-md-3 col-sm-6">
            <div class="img-container">
                @if(file_exists(public_path('img/' . $image['path'])))
                    <img src="{{ asset('img/' . $image['path']) }}" class="img-fluid" alt="{{ $image['alt'] }}" loading="lazy">
                @else
                    <div class="img-placeholder">
                        <i class="fas fa-university"></i>
                        <span>{{ $image['alt'] }}</span>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<br><br><br>

<section style="text-align: center; margin: 50px 0; background-color: #f9f9f9; padding: 40px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
    <h1 style="color: #1a096e; font-weight: bold; margin-bottom: 30px;">University Buildings</h1>

    <br><br>

    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                @if(file_exists(public_path('img/unvircity1.jpg')))
                    <img src="{{ asset('img/unvircity1.jpg') }}" class="building-img shadow-lg" alt="Educational Building">
                @else
                    <div style="width: 100%; height: 400px; background: #e2e8f0; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-building fa-5x" style="color: #D08301;"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <h2 class="building-title">Educational Building</h2>
                <p class="lead">
                    The Educational Building is one of the most important facilities at New Cairo Technological University.
                    It houses administrative offices, academic departments, and modern lecture halls that serve both students
                    and faculty. It is considered the main hub for educational and administrative activities within the university.
                </p>

                <div id="floorAccordion">
                    <div class="floor-card">
                        <button onclick="toggleFloor('floor1')">First Floor</button>
                        <div id="floor1" class="details-card">
                            <p class="building-text mb-0">
                                The first floor includes offices for the <strong>Information Technology Department</strong> faculty
                                members, along with <strong>lecture halls</strong> equipped with the latest teaching technologies.
                            </p>
                        </div>
                    </div>

                    <div class="floor-card">
                        <button onclick="toggleFloor('floor2')">Second Floor</button>
                        <div id="floor2" class="details-card">
                            <p class="building-text mb-0">
                                The second floor contains the <strong>Vice Dean for Student Affairs Office</strong>,
                                the <strong>Examination Control Office</strong>, and several <strong>lecture halls</strong> for
                                classes and assessments.
                            </p>
                        </div>
                    </div>

                    <div class="floor-card">
                        <button onclick="toggleFloor('floor3')">Third Floor</button>
                        <div id="floor3" class="details-card">
                            <p class="building-text mb-0">
                                This floor accommodates faculty offices for the <strong>Mechanical Engineering Department</strong>,
                                as well as <strong>assistants' offices</strong> and additional <strong>lecture halls</strong>.
                            </p>
                        </div>
                    </div>

                    <div class="floor-card">
                        <button onclick="toggleFloor('floor4')">Fourth Floor</button>
                        <div id="floor4" class="details-card">
                            <p class="building-text mb-0">
                                The fourth floor includes offices for professors from various departments,
                                along with dedicated rooms for <strong>practical training</strong> and <strong>academic meetings</strong>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br><br>

    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="building-title">Workshops Building</h2>
                <p class="lead">
                    The <strong>Workshops Building</strong> at <strong>New Cairo Technological University</strong>
                    is one of the most vital facilities that support students' <strong>practical and technical training</strong>.
                    It provides an advanced environment for <strong>hands-on learning</strong> and <strong>applied education</strong>
                    in fields such as <strong>Mechatronics</strong> and <strong>Autotronics</strong>.
                </p>

                <div id="educationAccordion">
                    <div class="floor-card mb-3">
                        <button class="floor-btn" onclick="toggleEducationFloor('edu1')">First Floor</button>
                        <div id="edu1" class="details-card">
                            <p class="building-text mb-0">
                                The first floor includes a number of <strong>training workshops</strong> dedicated to the
                                <strong>Mechatronics</strong> and <strong>Autotronics</strong> departments.
                                It provides an ideal environment for <strong>hands-on training</strong> and the development of
                                <strong>technical and mechanical skills</strong> through modern equipment and real-world applications.
                            </p>
                        </div>
                    </div>

                    <div class="floor-card mb-3">
                        <button class="floor-btn" onclick="toggleEducationFloor('edu2')">Second Floor</button>
                        <div id="edu2" class="details-card">
                            <p class="building-text mb-0">
                                The second floor is dedicated to <strong>lecture halls</strong> designed for both theoretical and
                                interactive learning. It provides a comfortable academic environment equipped with <strong>modern teaching tools</strong>
                                to support <strong>students' understanding</strong> of practical applications learned in the workshops.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                @if(file_exists(public_path('img/univercty2.jpg')))
                    <img src="{{ asset('img/univercty2.jpg') }}" class="building-img shadow-lg" alt="Workshops Building">
                @else
                    <div style="width: 100%; height: 400px; background: #e2e8f0; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-tools fa-5x" style="color: #D08301;"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <br><br>

    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                @if(file_exists(public_path('img/logo.png')))
                    <img src="{{ asset('img/logo.png') }}" class="workshop-img shadow-lg" alt="Administrative Building">
                @else
                    <div style="width: 100%; height: 400px; background: #e2e8f0; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-landmark fa-5x" style="color: #D08301;"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <h2 class="workshop-title">Administrative Building</h2>
                <p class="lead">
                    The Administrative Building at New Cairo Technological University is one of the core facilities
                    dedicated to supporting academic and administrative operations. It includes specialized offices, classrooms,
                    and resources that enhance the overall university experience.
                </p>

                <div id="floorAccordion">
                    <div class="floor-card mb-3">
                        <button onclick="toggleWorkshopFloor('ws-floor1')">First Floor</button>
                        <div id="ws-floor1" class="details-workshop">
                            <p class="workshop-text mb-0">
                                The first floor includes <strong>administrative offices</strong> and <strong>student services</strong>
                                where students can access various support resources and information.
                            </p>
                        </div>
                    </div>

                    <div class="floor-card mb-3">
                        <button onclick="toggleWorkshopFloor('ws-floor2')">Second Floor</button>
                        <div id="ws-floor2" class="details-workshop">
                            <p class="workshop-text mb-0">
                                The second floor is mainly dedicated to <strong>lecture halls</strong> and <strong>teaching rooms</strong>
                                designed for both theoretical and applied learning sessions.
                            </p>
                        </div>
                    </div>

                    <div class="floor-card mb-3">
                        <button onclick="toggleWorkshopFloor('ws-floor3')">Third Floor</button>
                        <div id="ws-floor3" class="details-workshop">
                            <p class="workshop-text mb-0">
                                The third floor includes <strong>specialized classrooms</strong> for senior students,
                                focusing on advanced research and graduation projects.
                            </p>
                        </div>
                    </div>

                    <div class="floor-card mb-3">
                        <button onclick="toggleWorkshopFloor('ws-floor4')">Fourth Floor</button>
                        <div id="ws-floor4" class="details-workshop">
                            <p class="workshop-text mb-0">
                                The fourth floor contains offices for <strong>administration</strong> and the
                                <strong>library</strong>, providing resources and services for students and staff.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<br><br>

<script>
    function toggleFloor(floorId) {
        const floor = document.getElementById(floorId);
        floor.style.display = floor.style.display === "none" || floor.style.display === "" ? "block" : "none";
    }

    function toggleEducationFloor(floorId) {
        const floor = document.getElementById(floorId);
        floor.style.display = floor.style.display === "none" || floor.style.display === "" ? "block" : "none";
    }

    function toggleWorkshopFloor(floorId) {
        const floor = document.getElementById(floorId);
        floor.style.display = floor.style.display === "none" || floor.style.display === "" ? "block" : "none";
    }
</script>
@endsection
