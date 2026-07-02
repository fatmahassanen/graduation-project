@extends('layouts.app')

@section('title', 'Internal Protocols - New Cairo University of Technology')

@section('content')
<style>
    :root {
        --blue: #1a096e;
        --gold: #D08301;
        --purple: #7c3aed;
    }

    .protocols-section {
        padding: 60px 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .year-divider {
        text-align: center;
        margin: 60px 0 40px;
        position: relative;
    }

    .year-divider h2 {
        display: inline-block;
        background: linear-gradient(135deg, var(--purple), #9333ea);
        color: white;
        padding: 15px 50px;
        border-radius: 50px;
        font-weight: 900;
        font-size: 2rem;
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.3);
        position: relative;
        z-index: 2;
    }

    .year-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--purple), transparent);
        z-index: 1;
    }

    .protocol-card {
        background: #fff;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        transition: all 0.4s ease;
        display: flex;
        overflow: hidden;
        border: 1px solid rgba(124, 58, 237, 0.1);
    }

    .protocol-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(124, 58, 237, 0.25);
        border-color: var(--purple);
    }

    .protocol-image-container {
        flex-shrink: 0;
        width: 45%;
        aspect-ratio: 16 / 9;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .protocol-image-container::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(147, 51, 234, 0.05) 100%);
        pointer-events: none;
    }

    .protocol-card:hover .protocol-image-container::after {
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
    }

    .protocol-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .protocol-card:hover .protocol-image-container img {
        transform: scale(1.05);
    }

    .protocol-image-container i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 5rem;
        color: var(--purple);
        opacity: 0.3;
    }

    .protocol-content {
        flex: 1;
        padding: 40px 45px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #fff;
        min-width: 0;
    }

    .protocol-content h3 {
        color: var(--blue);
        font-weight: 800;
        margin-bottom: 15px;
        font-size: 1.7rem;
        line-height: 1.3;
    }

    .protocol-org {
        color: var(--purple);
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 1.15rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .protocol-org i {
        font-size: 1.2rem;
    }

    .protocol-content p {
        color: #6c757d;
        line-height: 1.9;
        margin: 0;
        font-size: 1.05rem;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    .empty-state i {
        font-size: 5rem;
        color: var(--purple);
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: var(--blue);
        font-weight: 800;
        margin-bottom: 15px;
    }

    .empty-state p {
        color: #6c757d;
        font-size: 1.1rem;
    }

    @media (max-width: 992px) {
        .protocol-image-container {
            width: 50%;
        }

        .protocol-content {
            padding: 30px;
        }
    }

    @media (max-width: 768px) {
        .protocol-card {
            flex-direction: column;
        }

        .protocol-image-container {
            width: 100%;
            aspect-ratio: 16 / 9;
        }

        .protocol-content {
            padding: 25px;
        }

        .protocol-content h3 {
            font-size: 1.4rem;
        }

        .year-divider h2 {
            font-size: 1.5rem;
            padding: 12px 35px;
        }
    }
</style>

<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Internal Protocols</h1>
                <p class="text-white fs-5 animated slideInDown">Cooperation agreements within Egyptian institutions</p>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<section class="protocols-section">
    <div class="container">
        @if($protocols->count() > 0)
            @foreach($protocols as $year => $yearProtocols)
                <div class="year-divider">
                    <h2>{{ $year }}</h2>
                </div>

                <div class="row">
                    <div class="col-12">
                        @foreach($yearProtocols as $protocol)
                            <div class="protocol-card">
                                <div class="protocol-image-container">
                                    @if($protocol->image)
                                        <img src="{{ asset($protocol->image) }}" alt="{{ $protocol->title }}">
                                    @else
                                        <i class="fas fa-handshake"></i>
                                    @endif
                                </div>
                                <div class="protocol-content">
                                    <h3>{{ $protocol->title }}</h3>
                                    @if($protocol->organization_name)
                                        <div class="protocol-org">
                                            <i class="fas fa-building"></i>
                                            <span>{{ $protocol->organization_name }}</span>
                                        </div>
                                    @endif
                                    @if($protocol->description)
                                        <p>{{ $protocol->description }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-handshake"></i>
                <h3>No Internal Protocols Yet</h3>
                <p>Internal cooperation protocols will be displayed here once they are added.</p>
            </div>
        @endif
    </div>
</section>
@endsection
