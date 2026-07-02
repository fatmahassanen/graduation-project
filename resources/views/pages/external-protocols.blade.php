@extends('layouts.app')

@section('title', 'External Protocols - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">External Protocols</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">External Protocols</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-xxl py-5">
    <div class="container">

        @if($protocols->count() > 0)
            @foreach($protocols as $year => $yearProtocols)
                <div class="year-divider wow fadeInUp" data-wow-delay="0.1s">
                    <span>{{ $year }}</span>
                </div>
                <div class="row g-4 mb-5">
                    @foreach($yearProtocols as $index => $protocol)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 * ($index + 1) }}s">
                            <div class="protocol-card h-100">
                                <div class="protocol-img">
                                    @if($protocol->image)
                                        <img src="{{ asset($protocol->image) }}" alt="{{ $protocol->title }}">
                                    @else
                                        <img src="{{ asset('img/ex' . $year . '-' . ($index + 1) . '.jpg') }}" alt="{{ $protocol->title }}" onerror="this.src='{{ asset('img/placeholder.png') }}'">
                                    @endif
                                </div>
                                <div class="protocol-body">
                                    <h5>{{ $protocol->title }}</h5>
                                    @if($protocol->organization_name)
                                        <p class="text-warning small mb-2">{{ $protocol->organization_name }}</p>
                                    @endif
                                    <p>{{ $protocol->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <i class="fas fa-handshake fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">No protocols available</h3>
                <p class="text-muted">External cooperation protocols will be displayed here.</p>
            </div>
        @endif

    </div>
</div>

@endsection

@push('styles')
<style>
    .year-divider {
        text-align: center;
        margin: 50px 0 30px;
        position: relative;
    }
    .year-divider::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #D08301, transparent);
        z-index: 1;
    }
    .year-divider span {
        position: relative;
        z-index: 2;
        background: #1a096e;
        color: white;
        padding: 8px 35px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 1.4rem;
        box-shadow: 0 5px 15px rgba(26, 9, 110, 0.2);
    }
    .protocol-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.4s ease;
        border: 1px solid rgba(208, 131, 1, 0.1);
    }
    .protocol-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(26, 9, 110, 0.15);
        border-color: #D08301;
    }
    .protocol-img {
        height: 240px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        position: relative;
        overflow: hidden;
    }
    .protocol-img::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(208, 131, 1, 0.05) 0%, rgba(26, 9, 110, 0.05) 100%);
        pointer-events: none;
    }
    .protocol-card:hover .protocol-img::after {
        background: linear-gradient(135deg, rgba(208, 131, 1, 0.1) 0%, rgba(26, 9, 110, 0.1) 100%);
    }
    .protocol-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .protocol-card:hover .protocol-img img {
        transform: scale(1.08);
    }
    .protocol-body {
        padding: 30px;
        background: #fff;
    }
    .protocol-body h5 {
        color: #1a096e;
        font-weight: 800;
        font-size: 1.3rem;
        margin-bottom: 12px;
        line-height: 1.4;
    }
    .protocol-body .text-warning {
        color: #D08301 !important;
        font-weight: 600;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .protocol-body .text-warning::before {
        content: '\f1ad';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
    }
    .protocol-body p {
        font-size: 0.98rem;
        color: #6c757d;
        line-height: 1.8;
        margin-bottom: 0;
    }
</style>
@endpush

</content>
