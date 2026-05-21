@extends('layouts.app')

@section('title', 'Campus Tour - New Cairo University of Technology')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Campus Tour</h1>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Hero Video Card Start -->
<div class="container mt-5 position-relative">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden wow fadeInUp" data-wow-delay="0.2s">
        <video class="w-100" autoplay muted loop controls style="max-height: 420px; object-fit: cover;">
            <source src="{{ asset('img/videos/Campus Tour.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</div>
<!-- Hero Video Card End -->

<br><br><br>

<div class="container my-5">
    <div class="row g-3">
        <div class="col-md-3 col-sm-6">
            <div class="img-container">
                <img src="https://watanimg.elwatannews.com/image_archive/840x473/11954128811596557362.jpg"
                    class="img-fluid rounded shadow-sm" alt="University Building">
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="img-container">
                <img src="{{ asset('img/j.png') }}" class="img-fluid rounded shadow-sm" alt="Stadium">
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="img-container">
                <img src="{{ asset('img/t.png') }}" class="img-fluid rounded shadow-sm" alt="Academic Building">
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="img-container">
                <img src="{{ asset('img/a.jpg') }}" class="img-fluid rounded shadow-sm" alt="Gym">
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="img-container">
                <img src="{{ asset('img/5jpg.jpg') }}" class="img-fluid rounded shadow-sm" alt="Library">
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="img-container">
                <img src="{{ asset('img/d.png') }}" class="img-fluid rounded shadow-sm" alt="Lecture Hall">
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="img-container">
                <img src="{{ asset('img/ss.png') }}" class="img-fluid rounded shadow-sm" alt="Classroom">
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="img-container">
                <img src="{{ asset('img/hh.png') }}" class="img-fluid rounded shadow-sm" alt="Computer Lab">
            </div>
        </div>
    </div>
</div>

<br><br><br>

<section style="text-align: center; margin: 50px 0; background-color: #f9f9f9; padding: 40px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
    <h1 style="color: #003366; font-weight: bold; margin-bottom: 30px;">University Buildings</h1>

    <br><br>

    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                <img src="{{ asset('img/talem.png') }}" class="building-img shadow-lg" alt="Educational Building">
            </div>
            <div class="col-md-6">
                <h2 class="building-title">Educational Building</h2>
                <p class="lead">
                    The Educational Building is one of the most important facilities at New Cairo Technological University.
                    It houses administrative offices, academic departments, and modern lecture halls that serve both students
                    and faculty. It is considered the main hub for educational and administrative activities within the university.
                </p>

                <div id="floorAccordion">
                    <!-- First Floor -->
                    <div class="floor-card">
                        <button onclick="toggleFloor('floor1')">First Floor</button>
                        <div id="floor1" class="details-card" style="display: none;">
                            <p class="building-text mb-0">
                                The first floor includes offices for the <strong>Information Technology Department</strong> faculty
                                members, along with <strong>lecture halls</strong> equipped with the latest teaching technologies.
                            </p>
                        </div>
                    </div>

                    <!-- Second Floor -->
                    <div class="floor-card">
                        <button onclick="toggleFloor('floor2')">Second Floor</button>
                        <div id="floor2" class="details-card" style="display: none;">
                            <p class="building-text mb-0">
                                The second floor contains the <strong>Vice Dean for Student Affairs Office</strong>,
                                the <strong>Examination Control Office</strong>, and several <strong>lecture halls</strong> for
                                classes and assessments.
                            </p>
                        </div>
                    </div>

                    <!-- Third Floor -->
                    <div class="floor-card">
                        <button onclick="toggleFloor('floor3')">Third Floor</button>
                        <div id="floor3" class="details-card" style="display: none;">
                            <p class="building-text mb-0">
                                This floor accommodates faculty offices for the <strong>Mechanical Engineering Department</strong>,
                                as well as <strong>assistants' offices</strong> and additional <strong>lecture halls</strong>.
                            </p>
                        </div>
                    </div>

                    <!-- Fourth Floor -->
                    <div class="floor-card">
                        <button onclick="toggleFloor('floor4')">Fourth Floor</button>
                        <div id="floor4" class="details-card" style="display: none;">
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

    <!-- Workshops Building Section -->
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
                    <!-- First Floor -->
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

                    <!-- Second Floor -->
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
                <img src="{{ asset('img/ggg.png') }}" class="building-img shadow-lg" alt="Workshops Building">
            </div>
        </div>
    </div>

    <br><br>

    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                <img src="{{ asset('img/A.png') }}" class="workshop-img shadow-lg" alt="Administrative Building">
            </div>
            <div class="col-md-6">
                <h2 class="workshop-title">Administrative Building</h2>
                <p class="lead">
                    The Workshops Building at New Cairo Technological University is one of the core facilities
                    dedicated to hands-on learning and technical training. It includes specialized labs, classrooms,
                    and offices that enhance students' practical skills in various technological fields.
                </p>

                <div id="floorAccordion">
                    <!-- First Floor -->
                    <div class="floor-card mb-3">
                        <button onclick="toggleWorkshopFloor('ws-floor1')">First Floor</button>
                        <div id="ws-floor1" class="details-workshop">
                            <p class="workshop-text mb-0">
                                The first floor includes <strong>technical workshops</strong> and <strong>training areas</strong>
                                where students gain practical experience using modern industrial tools and equipment.
                            </p>
                        </div>
                    </div>

                    <!-- Second Floor -->
                    <div class="floor-card mb-3">
                        <button onclick="toggleWorkshopFloor('ws-floor2')">Second Floor</button>
                        <div id="ws-floor2" class="details-workshop">
                            <p class="workshop-text mb-0">
                                The second floor is mainly dedicated to <strong>lecture halls</strong> and <strong>teaching rooms</strong>
                                designed for both theoretical and applied learning sessions.
                            </p>
                        </div>
                    </div>

                    <!-- Third Floor -->
                    <div class="floor-card mb-3">
                        <button onclick="toggleWorkshopFloor('ws-floor3')">Third Floor</button>
                        <div id="ws-floor3" class="details-workshop">
                            <p class="workshop-text mb-0">
                                The third floor includes <strong>specialized classrooms</strong> for senior students,
                                focusing on advanced research and graduation projects.
                            </p>
                        </div>
                    </div>

                    <!-- Fourth Floor -->
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
        if (floor.style.display === "none" || floor.style.display === "") {
            floor.style.display = "block";
        } else {
            floor.style.display = "none";
        }
    }

    function toggleEducationFloor(floorId) {
        const floor = document.getElementById(floorId);
        if (floor.style.display === "none" || floor.style.display === "") {
            floor.style.display = "block";
        } else {
            floor.style.display = "none";
        }
    }

    function toggleWorkshopFloor(floorId) {
        const floor = document.getElementById(floorId);
        if (floor.style.display === "none" || floor.style.display === "") {
            floor.style.display = "block";
        } else {
            floor.style.display = "none";
        }
    }
</script>
@endsection
