@extends('layouts.app')

@section('title', $page->title)

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">{{ $page->title }}</h1>
                <nav aria-label="breadcrumb">
                    <!-- Breadcrumb can be added here if needed -->
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Dynamic Content -->
{!! $page->content !!}
@endsection
