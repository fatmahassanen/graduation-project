<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">{{ $title }}</h1>
                @if($description)
                    <p class="text-white mb-4 animated slideInDown">{{ $description }}</p>
                @endif
                @if($ctaText && $ctaLink)
                    <a href="{{ $ctaLink }}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">
                        {{ $ctaText }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
