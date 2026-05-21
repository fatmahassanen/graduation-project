@extends('layouts.app')

@section('title', ' student booking.Value.ToUpper() tudent  student booking.Value.ToUpper() ooking - New Cairo University of Technology')

@section('content')
<style>
    :root {
        --blue: #1a096e;
        --gold: #D08301;
    }

    .president-section {
        padding: 60px 20px;
        display: flex;
        flex-direction: column;
        gap: 40px;
        align-items: center;
    }

    .president-card {
        background: #fff;
        border-left: 8px solid var(--gold);
        border-radius: 20px;
        padding: 30px 40px;
        max-width: 1000px;
        width: 100%;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        transition: all 0.4s ease;
    }

    .president-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    }

    .president-card h1 {
        color: var(--blue);
        font-weight: 900;
        margin-bottom: 20px;
    }
</style>

<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown"> student booking.Value.ToUpper() tudent  student booking.Value.ToUpper() ooking</h1>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<section class="president-section">
    <div class="president-card">
        <br>
        <h1> student booking.Value.ToUpper() tudent  student booking.Value.ToUpper() ooking</h1>
        <br>
        <p>Content coming soon...</p>
    </div>
</section>
@endsection
