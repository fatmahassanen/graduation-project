<div class="container-xxl py-5">
    <div class="container">
        @if($title)
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Gallery</h6>
                <h1 class="mb-5">{{ $title }}</h1>
            </div>
        @endif

        <div class="row g-4">
            @foreach($images as $index => $image)
                <div class="{{ $getColumnClass() }} wow fadeInUp" data-wow-delay="{{ ($index * 0.1) + 0.1 }}s">
                    <div class="img-container">
                        <img class="img-fluid" 
                             src="{{ $image['url'] }}" 
                             alt="{{ $image['alt'] ?? 'Gallery Image' }}"
                             loading="lazy">
                    </div>
                    @if(isset($image['caption']))
                        <p class="text-center mt-2">{{ $image['caption'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
