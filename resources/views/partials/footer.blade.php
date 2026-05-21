<!-- Footer Start -->
<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Quick Link</h4>
                <a class="btn btn-link" href="{{ url('/about') }}">About Us</a>
                <a class="btn btn-link" href="{{ route('contact') }}">Contact Us</a>
                <a class="btn btn-link" href="{{ route('departments') }}">Courses</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Contact</h4>
                <a href="https://www.google.com/maps/search/%D8%AC%D8%A7%D9%85%D8%B9%D9%87+%D8%A7%D9%84%D9%82%D8%A7%D9%87%D8%B1%D9%87+%D8%A7%D9%84%D8%AC%D8%AF%D9%8A%D8%AF%D9%87+%D8%A7%D9%84%D8%AA%D9%83%D9%86%D9%88%D9%84%D9%88%D8%AC%D9%8A%D8%A7%E2%80%AD%E2%80%AD/@30.022714,31.5229726,17z?entry=ttu&g_ep=EgoyMDI1MDQwOS4wIKXMDSoASAFQAw%3D%3D">
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>{{ $globalSettings['site_address'] ?? 'El Lotus, First New Cairo, New Cairo' }}</p>
                </a>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>{{ $globalSettings['site_phone'] ?? '0225390250' }}</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>{{ $globalSettings['site_email'] ?? 'info@nctu.edu.eg' }}</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/nctu.edu.eg/?locale=ar_AR"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href="https://www.instagram.com/explore/locations/113014853445529/new-cairo-technological-university/"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-light btn-social" href="https://t.me/+hu88qUXmcXNlNmQ0"><i class="fab fa-telegram"></i></a>
                    <a class="btn btn-outline-light btn-social" href="https://www.linkedin.com/school/nct-uni/"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery">
                <h4 class="text-white mb-3">Gallery</h4>
                <div class="row g-2 pt-2">
                    <div class="col-4">
                        <a href="{{ route('departments') }}"><img class="img-fluid bg-light p-1" src="{{ asset('img/Departments/information technology.jpg') }}" alt="infotech"></a>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('departments') }}"><img class="img-fluid bg-light p-1" src="{{ asset('img/Departments/Mechatronic.jpg') }}" alt="Mecha"></a>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('departments') }}"><img class="img-fluid bg-light p-1" src="{{ asset('img/Departments/Autotronics.jpg') }}" alt="Auto"></a>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('departments') }}"><img class="img-fluid bg-light p-1" src="{{ asset('img/Departments/Petroleum engineering.jpg') }}" alt="petroleum"></a>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('departments') }}"><img class="img-fluid bg-light p-1" src="{{ asset('img/Departments/Prosthetics.jpg') }}" alt="Prosthetic"></a>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('departments') }}"><img class="img-fluid bg-light p-1" src="{{ asset('img/Departments/Renewable energy.jpg') }}" alt="energy"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div style="display: flex; justify-content: center; align-items: center; text-align: center;">
                    <p>&copy; 2025 New Cairo Technological University. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->
