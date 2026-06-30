@extends('layouts.app')

@section('title', 'Courses and Workshops - Quality Assurance - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Courses and Workshops</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="{{ route('quality.index') }}">Quality Assurance</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Courses and Workshops</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-5">
    <div class="alert alert-info">
        <h4>Courses and Workshops</h4>
        <p>Content coming soon.</p>
    </div>
</div>

@endsection
