<div class="container mt-5 position-relative">
    @if($title)
        <div class="text-center mb-4">
            <h2 class="mb-3">{{ $title }}</h2>
            @if($description)
                <p class="text-muted">{{ $description }}</p>
            @endif
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden wow fadeInUp" data-wow-delay="0.2s">
        <video class="w-100" 
               @if($autoplay) autoplay @endif 
               muted 
               loop 
               @if($controls) controls @endif
               style="max-height: 420px; object-fit: cover;">
            <source src="{{ $videoUrl }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</div>
