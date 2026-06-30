@extends('layouts.app')

@section('title', 'Internal Regulations - Quality Assurance - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Internal Regulations<br>of the Unit</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="{{ route('quality.index') }}">Quality Assurance</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Internal Regulations</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container my-5 text-center">
    <img src="{{ asset('img/الهيكل التنظيمى.png') }}" alt="Internal Regulations Organizational Structure" 
         class="img-fluid rounded shadow-lg" style="max-width: 90%; border: 5px solid #D08301;">
</div>

@endsection
