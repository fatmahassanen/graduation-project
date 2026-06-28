@extends('layouts.app')

@section('title', 'Online Application - NCTU')

@section('content')


{{-- <div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Apply Online</h1>
        <p class="text-white">Join the future of technology in a few simple steps</p>
        <nav aria-label="breadcrumb">
        </nav>
    </div>
</div> --}}
<div class="container-xxl py-5">
    <div class="container">
        <main class="apply-wrap shadow-lg p-4 p-md-5 rounded-4" style="background: #07102b; color: #fff; border: 1px solid rgba(255,255,255,0.1);">
            <div class="apply-header d-flex flex-column align-items-center text-center mb-4">
                <div class="brand-badge p-2 rounded-3 bg-primary shadow mb-3">
                    <img src="{{ asset('img/sub-sub-logo.png') }}" alt="Logo" style="width: 50px;">
                </div>
                <div>
                    <h2 class="h4 mb-0 text-white">Admission Portal — Academic Year 2026</h2>
                    <p class="small mb-0 text-info">Please follow the steps to complete your registration.</p>
                </div>
            </div>

            <div class="stepper mb-5 position-relative">
                <div class="progress-line position-absolute top-50 start-0 w-100 bg-secondary rounded-pill" style="height: 4px; transform: translateY(-50%);">
                    <div class="progress-fill bg-warning rounded-pill" id="progressFill" style="height: 100%; width: 0%; transition: 0.5s;"></div>
                </div>
                <div class="steps d-flex justify-content-between position-relative z-index-1">
                    <div class="step active text-center" data-step="1">
                        <div class="dot bg-dark border border-secondary rounded-3 d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 50px; height: 50px;">
                            <i class="fa fa-info-circle"></i>
                        </div>
                        <span class="small">Overview</span>
                    </div>
                    <div class="step text-center" data-step="2">
                        <div class="dot bg-dark border border-secondary rounded-3 d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 50px; height: 50px;">
                            <i class="fa fa-upload"></i>
                        </div>
                        <span class="small">Upload</span>
                    </div>
                    <div class="step text-center" data-step="3">
                        <div class="dot bg-dark border border-secondary rounded-3 d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 50px; height: 50px;">
                            <i class="fa fa-university"></i>
                        </div>
                        <span class="small">Visit</span>
                    </div>
                </div>
            </div>

            <section id="panel1" class="panel animated fadeIn text-align-center">
                <h3 class="text-warning mb-3">Step 1 — Instructions</h3>
                <p>Welcome to the official admission portal of New Cairo Technological University. To ensure a smooth application, please note:</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Ensure all scanned documents are clear and in PDF or Image format.</li>
                    <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Double-check your National ID and Phone number.</li>
                    <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> After online submission, a physical visit with original documents is mandatory.</li>
                </ul>
                <button class="btn btn-warning fw-bold px-5 py-2 mt-4 rounded-pill" id="toStep2">Start Application</button>
            </section>

            <section id="panel2" class="panel d-none animated fadeIn">
                <form id="applicationForm">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label text-light">Full Name (As in Passport/ID)</label>
                            <input type="text" class="form-control bg-dark border-secondary text-white" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-light">National ID Number</label>
                            <input type="text" class="form-control bg-dark border-secondary text-white" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-light">The required college</label>
                            <select id="collegeSelect" class="form-select bg-dark border-secondary text-white" required onchange="updateDepartments()">
                                <option value="">Choose your college</option>
                                <option value="industrial" >College of Industrial Technology and Energy</option>
                                <option value="health">College of Health Sciences</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label text-light">Desired Department</label>
                            <select id="deptSelect" class="form-select bg-dark border-secondary text-white" required disabled>
                                <option value="">Choose your major...</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4">
                            <h5 class="text-warning border-bottom pb-2 mb-3">Document Upload (Scan Copies)</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small text-secondary">High School Certificate</label>
                                    <input type="file" class="form-control form-control-sm bg-dark border-secondary text-white" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Final Nomination Card</label>
                                    <input type="file" class="form-control form-control-sm bg-dark border-secondary text-white required">
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Personal Photo (4x6)</label>
                                    <input type="file" class="form-control form-control-sm bg-dark border-secondary text-white required">
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Birth Certificate</label>
                                    <input type="file" class="form-control form-control-sm bg-dark border-secondary text-white required">
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Military Service Certificate (Males)</label>
                                    <input type="file" class="form-control form-control-sm bg-dark border-secondary text-white required">
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Guardian ID Copy</label>
                                    <input type="file" class="form-control form-control-sm bg-dark border-secondary text-white required">
                                </div>
                            </div>


                        </div>

                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-warning px-5 py-2 rounded-pill fw-bold">Submit Application</button>
                        </div>
                    </div>
                </form>
            </section>

            <section id="panel3" class="panel d-none text-center animated bounceIn">
                <div class="py-5">
                    <i class="fa fa-check-circle fa-5x text-success mb-4"></i>
                    <h3 class="text-white">Application Received!</h3>
                    <p class="text-secondary">Your digital application has been submitted successfully.</p>
                    <div class="bg-dark p-4 rounded-3 border border-secondary mb-4 mx-auto" style="max-width: 500px;">
                        <h6 class="text-warning">Next Step: Campus Visit</h6>
                        <p class="small mb-0 text-light">Please visit the university with your **original documents** and the payment receipt to finalize your registration.</p>
                    </div>

                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline-warning rounded-pill px-5">Back to Home</a>
                </div>
            </section>
        </main>
    </div>
</div>

@endsection

@push('styles')
<style>
    .step.active .dot { background: #D08301 !important; color: #fff !important; border-color: #ffd700 !important; transform: scale(1.1); transition: 0.3s; }
    .step.completed .dot { background: #198754 !important; border-color: #198754 !important; color: #fff; }
    .panel { min-height: 400px; }
    .form-control:focus, .form-select:focus { background: #0a1435 !important; border-color: #D08301 !important; color: #fff !important; box-shadow: none; }
    .page-header { background: linear-gradient(rgba(26, 9, 110, 0.8), rgba(26, 9, 110, 0.8)), url('{{ asset("img/campus.jpg") }}'); background-size: cover; }
</style>
@endpush

@push('scripts')
<script>
    const steps = document.querySelectorAll('.step');
    const panels = document.querySelectorAll('.panel');
    const progressFill = document.getElementById('progressFill');

    function showStep(stepNumber) {
        panels.forEach((panel, index) => {
            if (index + 1 === stepNumber) {
                panel.classList.remove('d-none');
            } else {
                panel.classList.add('d-none');
            }
        });

        steps.forEach((step, index) => {
            const idx = index + 1;
            if (idx === stepNumber) {
                step.classList.add('active');
                step.classList.remove('completed');
            } else if (idx < stepNumber) {
                step.classList.remove('active');
                step.classList.add('completed');
                step.querySelector('i').className = "fa fa-check"; // Change icon to check
            } else {
                step.classList.remove('active', 'completed');
            }
        });

        progressFill.style.width = ((stepNumber - 1) / (steps.length - 1)) * 100 + '%';
    }

    document.getElementById('toStep2').addEventListener('click', () => showStep(2));

    document.getElementById('applicationForm').addEventListener('submit', (e) => {
        e.preventDefault();
        // Here you would normally use AJAX to submit the form data to Laravel
        showStep(3);
    });

    function updateDepartments() {
        const collegeSelect = document.getElementById('collegeSelect');
        const deptSelect = document.getElementById('deptSelect');

        // Map colleges to their departments
        const data = {
            'industrial': [
                'Information & Communication Technology (ICT)',
                'Mechatronics Technology',
                'Autotronics Technology',
                'Renewable Energy Technology'
            ],
            'health': [
                'Prosthetics & Orthotics (Health Science)'
            ]
        };

        const selectedCollege = collegeSelect.value;

        // Reset department dropdown
        deptSelect.innerHTML = '<option value="">Choose your major...</option>';

        if (selectedCollege && data[selectedCollege]) {
            // Enable dropdown
            deptSelect.disabled = false;

            // Fill with new options
            data[selectedCollege].forEach(dept => {
                let option = document.createElement('option');
                option.text = dept;
                option.value = dept;
                deptSelect.add(option);
            });
        } else {
            // Disable if no college is selected
            deptSelect.disabled = true;
        }
    }
</script>
@endpush
