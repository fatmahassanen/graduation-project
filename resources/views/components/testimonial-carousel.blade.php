<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        @if($title)
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Testimonials</h6>
                <h1 class="mb-5">{{ $title }}</h1>
            </div>
        @endif

        <div class="owl-carousel testimonial-carousel position-relative">
            @foreach($testimonials as $testimonial)
                <div class="testimonial-item text-center">
                    @if(isset($testimonial['image']))
                        <img class="border rounded-circle p-2 mx-auto mb-3" 
                             loading="lazy"
                             src="{{ $testimonial['image'] }}" 
                             style="width: 80px; height: 80px;"
                             alt="{{ $testimonial['name'] ?? 'Testimonial' }}"
                             loading="lazy">
                    @endif
                    <h5 class="mb-0">{{ $testimonial['name'] ?? '' }}</h5>
                    @if(isset($testimonial['position']))
                        <p>{{ $testimonial['position'] }}</p>
                    @endif
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">{{ $testimonial['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
