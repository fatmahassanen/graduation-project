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
        border-left: 8px solid var(--purple);
        border-radius: 20px;
        padding: 30px 40px;
        margin-bottom: 30px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .protocol-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(124, 58, 237, 0.2);
        border-left-color: #9333ea;
    }

    .protocol-logo {
        flex-shrink: 0;
        width: 120px;
        height: 120px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .protocol-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 10px;
    }

    .protocol-logo i {
        font-size: 3rem;
        color: var(--purple);
    }

    .protocol-content {
        flex: 1;
    }

    .protocol-content h3 {
        color: var(--blue);
        font-weight: 800;
        margin-bottom: 10px;
        font-size: 1.5rem;
    }

    .protocol-org {
        color: var(--purple);
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .protocol-content p {
        color: #6c757d;
        line-height: 1.8;
        margin: 0;
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

    @media (max-width: 768px) {
        .protocol-card {
            flex-direction: column;
            text-align: center;
            padding: 25px;
        }

        .protocol-logo {
            width: 100px;
            height: 100px;
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
                                <div class="protocol-logo">
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
                                            <i class="fas fa-building me-2"></i>{{ $protocol->organization_name }}
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
