@extends('layouts.app')

@section('title', 'Top 10 Reasons - New Cairo University of Technology')

@section('content')
<style>
    .full-video-container {
        position: relative;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }

    .full-video-container video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(70%);
    }

    .video-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
    }

    .video-overlay h2 {
        font-size: 48px;
        margin-bottom: 15px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
    }

    .video-overlay p {
        font-size: 24px;
        text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.7);
    }

    @media (max-width: 768px) {
        .video-overlay h2 {
            font-size: 32px;
        }

        .video-overlay p {
            font-size: 18px;
        }
    }

    .multi-section {
        padding: 60px 10%;
        font-family: 'Segoe UI', sans-serif;
    }

    .item-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        flex-wrap: wrap;
        margin-bottom: 60px;
    }

    .image-box {
        flex: 1;
        max-width: 45%;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.4s ease;
    }

    .image-box img {
        width: 100%;
        height: auto;
        border-radius: 15px;
        transition: transform 0.5s ease;
    }

    .image-box:hover img {
        transform: scale(1.1);
    }

    .text-box {
        flex: 1;
        max-width: 50%;
        color: #003366;
    }

    .left-img .text-box {
        text-align: right;
    }

    .right-img .text-box {
        text-align: left;
    }

    .text-box h2 {
        font-size: 28px;
        margin-bottom: 15px;
        color: #002244;
    }

    .text-box p {
        font-size: 18px;
        line-height: 1.7;
        text-align: justify;
        text-justify: inter-word;
    }

    @media (max-width: 768px) {
        .item-container {
            flex-direction: column;
            text-align: center;
        }

        .right-img,
        .left-img {
            flex-direction: column;
        }

        .text-box {
            max-width: 100% !important;
            text-align: center !important;
        }

        .image-box {
            max-width: 100%;
        }
    }
</style>

<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Top 10 Questions for Choosing New Cairo University</h1>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<div class="full-video-container">
    <video id="mainVideo" controls>
        <source src="{{ url('https://nctu.site/img/jama.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="video-overlay">
        <h2>Welcome to New Cairo Technological University</h2>
    </div>
</div>

<section class="question-section">
    <div class="title-box">
        Top 10 Questions for Choosing New Cairo University
    </div>
</section>

<section class="multi-section">
    <!-- Item 1 -->
    <div class="item-container left-img">
        <div class="image-box"><img src="{{ asset('img/rr.png') }}" alt="Image 1"></div>
        <div class="text-box">
            <h2>New Cairo Technological University</h2>
            <p>New Cairo Technological University actively participates in international competitions,
                showcasing the creativity and excellence of its students on a global stage.</p>
        </div>
    </div>

    <!-- Item 2 -->
    <div class="item-container right-img">
        <div class="text-box">
            <h2>Join NCT Graduates</h2>
            <p>Join the graduates of NCT University, known for having one of the highest employment
                rates among Egyptian graduates (according to the Central Agency for Public Mobilization and Statistics).
                Our strong support system ensures a smooth transition from university to the job market</p>
        </div>
        <div class="image-box"><img src="{{ asset('img/kk.png') }}" alt="Image 2"></div>
    </div>

    <!-- Item 3 -->
    <div class="item-container left-img">
        <div class="image-box"><img src="{{ asset('img/sh.png') }}" alt="Image 3"></div>
        <div class="text-box">
            <h2>Student Activities at New Cairo Technological University</h2>
            <p>New Cairo Technological University offers a vibrant campus life with diverse student activities,
                clubs, and events. These programs aim to foster creativity, teamwork, and leadership skills, providing
                students with opportunities to grow both academically and personally while engaging in social, cultural, and scientific initiatives.</p>
        </div>
    </div>

    <!-- Item 4 -->
    <div class="item-container right-img">
        <div class="text-box">
            <h2>Green Hydrogen Research Collaboration</h2>
            <p>A meeting was held under Professor Dr. Tarek Abdelmalak's patronage to launch student and postgraduate
                research projects, focusing on the production and industrial application of green hydrogen.</p>
        </div>
        <div class="image-box"><img src="{{ asset('img/ww.pgn.png') }}" alt="Image 2"></div>
    </div>

    <!-- Item 5 -->
    <div class="item-container left-img">
        <div class="image-box"><img src="{{ asset('img/ms.png') }}" alt="Image 3"></div>
        <div class="text-box">
            <h2>New Cairo Technological University in Competitions</h2>
            <p>New Cairo Technological University actively participates in national and international competitions,
                showcasing the talent, creativity, and excellence of its students. These competitions provide valuable
                experience, enhance practical skills, and highlight the university's commitment to innovation and academic achievement.</p>
        </div>
    </div>

    <!-- Item 6 -->
    <div class="item-container right-img">
        <div class="text-box">
            <h2>Honoring Young Scientists at New Cairo Technological University</h2>
            <p>New Cairo Technological University honored young scientists in collaboration with IP Wave Books,
                recognizing outstanding children in reading, innovation, and scientific activities
                under the patronage of Professor Dr. Tarek Abdelmalak.</p>
        </div>
        <div class="image-box"><img src="{{ asset('img/tk.png') }}" alt="Image 2"></div>
    </div>

    <!-- Item 7 -->
    <div class="item-container left-img">
        <div class="image-box"><img src="{{ asset('img/am.png') }}" alt="Image 3"></div>
        <div class="text-box">
            <h2>NCT University Signs Cooperation Protocol</h2>
            <p>NCT University signed a protocol with New Cairo Industry & Trade Company to enhance
                student training and skill development, preparing them for the labor market.</p>
        </div>
    </div>

    <!-- Item 8 -->
    <div class="item-container right-img">
        <div class="text-box">
            <h2>Active Participation of NCT University in German Science Day 2025</h2>
            <p>Under the patronage of Professor Dr. Tarek Abdelmalak, NCT University actively
                participated in the 11th German Science Day 2025 at Marriott Zamalek. Faculty members attended the event
                organized by DAAD and the COSIMENA project, promoting scientific research and international academic collaboration.</p>
        </div>
        <div class="image-box"><img src="{{ asset('img/lady.png') }}" alt="Image 2"></div>
    </div>

    <!-- Item 9 -->
    <div class="item-container left-img">
        <div class="image-box"><img src="{{ asset('img/ebtk.png') }}" alt="Image 3"></div>
        <div class="text-box">
            <h2>A Year of Excellence | Student Activities Highlights 2024/2025</h2>
            <p>Under the university leadership, NCT students excelled in innovation, sports, conferences, and competitions,
                earning top prizes and recognition locally and internationally.</p>
        </div>
    </div>

    <!-- Item 10 -->
    <div class="item-container right-img">
        <div class="text-box">
            <h2>NCT University Participates in Alamein Universities Championship</h2>
            <p>NCT University actively participated in the first Alamein Universities Championship under the patronage
                of Professor Dr. Tarek Abdelmalak and other university leaders, alongside numerous
                public, private, and technological universities across Egypt.</p>
        </div>
        <div class="image-box"><img src="{{ asset('img/almen.png') }}" alt="Image 2"></div>
    </div>
</section>
@endsection
