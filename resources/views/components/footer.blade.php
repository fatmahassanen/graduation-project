<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            {{-- Quick Links --}}
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Quick Link</h4>
                @foreach($quickLinks as $link)
                    <a class="btn btn-link" href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                @endforeach
            </div>

            {{-- Contact Information --}}
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Contact</h4>
                @foreach($contactInfo as $info)
                    @if(isset($info['url']))
                        <a href="{{ $info['url'] }}" target="_blank" rel="noopener noreferrer">
                            <p class="mb-2">
                                <i class="{{ $info['icon'] }} me-3"></i>{{ $info['value'] }}
                            </p>
                        </a>
                    @else
                        <p class="mb-2">
                            <i class="{{ $info['icon'] }} me-3"></i>{{ $info['value'] }}
                        </p>
                    @endif
                @endforeach

                {{-- Social Media Links --}}
                <div class="d-flex pt-2">
                    @foreach($socialLinks as $social)
                        <a class="btn btn-outline-light btn-social" 
                           href="{{ $social['url'] }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           aria-label="{{ $social['label'] }}">
                            <i class="{{ $social['icon'] }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Gallery --}}
            <div class="col-lg-3 col-md-6 gallery">
                <h4 class="text-white mb-3">Gallery</h4>
                <div class="row g-2 pt-2">
                    @foreach($galleryImages as $image)
                        <div class="col-4">
                            <a href="{{ $image['url'] }}">
                                <img class="img-fluid bg-light p-1" 
                                     loading="lazy"
                                     src="{{ $image['image'] }}" 
                                     alt="{{ $image['alt'] }}"
                                     loading="lazy">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div style="display: flex; justify-content: center; align-items: center; text-align: center;">
                    <p>&copy; {{ date('Y') }} New Cairo Technological University. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</div>
