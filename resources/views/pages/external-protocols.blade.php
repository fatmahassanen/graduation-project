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
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: all 0.4s ease;
        border: 1px solid #f0f0f0;
    }
    .protocol-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(26, 9, 110, 0.12);
        border-color: #D08301;
    }
    .protocol-img {
        height: 180px;
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 25px;
    }
    .protocol-img img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        filter: grayscale(20%);
        transition: 0.4s;
    }
    .protocol-card:hover img {
        filter: grayscale(0%);
        transform: scale(1.05);
    }
    .protocol-body {
        padding: 25px;
        border-top: 1px solid #f8f8f8;
    }
    .protocol-body h5 {
        color: #1a096e;
        font-weight: 800;
        font-size: 1.15rem;
        margin-bottom: 12px;
        line-height: 1.4;
    }
    .protocol-body p {
        font-size: 0.92rem;
        color: #555;
        line-height: 1.6;
        margin-bottom: 0;
    }
</style>
@endpush

</content>
