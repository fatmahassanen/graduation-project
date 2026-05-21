<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">{{ $title ?? 'Page Title' }}</h1>
                <nav aria-label="breadcrumb">
                    @if(isset($breadcrumbs) && $breadcrumbs)
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                        @if(isset($breadcrumb))
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ $breadcrumb }}</li>
                        @endif
                    </ol>
                    @endif
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->
