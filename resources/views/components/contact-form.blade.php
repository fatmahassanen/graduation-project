<div class="container-xxl py-5">
    <div class="container">
        @if($title)
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-orange px-3">Contact Us</h6>
                <h1 class="mb-5">{{ $title }}</h1>
            </div>
        @endif

        <div class="row g-4">
            {{-- Contact Information --}}
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <h5>Get In Touch</h5>
                @if($description)
                    <p class="mb-4">{{ $description }}</p>
                @endif

                @foreach($contactInfo as $info)
                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary"
                             style="width: 50px; height: 50px;">
                            <i class="{{ $info['icon'] }} text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-primary">{{ $info['label'] }}</h5>
                            @if(isset($info['url']))
                                <a href="{{ $info['url'] }}" target="_blank" rel="noopener noreferrer">
                                    <p class="mb-0">{{ $info['value'] }}</p>
                                </a>
                            @else
                                <p class="mb-0">{{ $info['value'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Map --}}
            @if($mapUrl)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <iframe class="position-relative rounded w-100 h-100"
                            src="{{ $mapUrl }}"
                            frameborder="0" 
                            style="min-height: 300px; border:0;" 
                            allowfullscreen="" 
                            aria-hidden="false"
                            tabindex="0"></iframe>
                </div>
            @endif

            {{-- Contact Form --}}
            <div class="col-lg-4 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Error Messages --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" placeholder="Your Name" 
                                       value="{{ old('name') }}" required maxlength="255">
                                <label for="name">Your Name *</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" placeholder="Your Email" 
                                       value="{{ old('email') }}" required maxlength="255">
                                <label for="email">Your Email *</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" placeholder="Your Phone" 
                                       value="{{ old('phone') }}" maxlength="50">
                                <label for="phone">Your Phone (Optional)</label>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                       id="subject" name="subject" placeholder="Subject" 
                                       value="{{ old('subject') }}" required maxlength="255">
                                <label for="subject">Subject *</label>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          placeholder="Leave a message here" 
                                          id="message" name="message" 
                                          style="height: 150px" required maxlength="5000">{{ old('message') }}</textarea>
                                <label for="message">Message *</label>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- reCAPTCHA --}}
                        @if(config('services.recaptcha.site_key'))
                        <div class="col-12">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                            @error('g-recaptcha-response')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit" style="background: #D08301; border-color: #D08301;">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(config('services.recaptcha.site_key'))
@push('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
@endif

@push('scripts')
<script>
    // Client-side validation
    document.getElementById('contactForm')?.addEventListener('submit', function(e) {
        let isValid = true;
        const form = this;

        // Validate name
        const name = form.querySelector('#name');
        if (name.value.trim().length < 2) {
            isValid = false;
            name.classList.add('is-invalid');
        } else {
            name.classList.remove('is-invalid');
        }

        // Validate email
        const email = form.querySelector('#email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            isValid = false;
            email.classList.add('is-invalid');
        } else {
            email.classList.remove('is-invalid');
        }

        // Validate subject
        const subject = form.querySelector('#subject');
        if (subject.value.trim().length < 3) {
            isValid = false;
            subject.classList.add('is-invalid');
        } else {
            subject.classList.remove('is-invalid');
        }

        // Validate message
        const message = form.querySelector('#message');
        if (message.value.trim().length < 10) {
            isValid = false;
            message.classList.add('is-invalid');
        } else {
            message.classList.remove('is-invalid');
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
</script>
@endpush