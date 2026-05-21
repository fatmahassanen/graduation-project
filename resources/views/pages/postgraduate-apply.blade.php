@extends('layouts.app')

@section('title', 'Postgraduate Application - NCTU')

@section('content')

<div class="container-xxl py-5">
    <div class="container">
        <main class="apply-wrap shadow-lg p-4 p-md-5 rounded-4" style="background: #07102b; color: #fff; border: 1px solid rgba(255,255,255,0.1);">

            <div class="apply-header d-flex flex-column align-items-center text-center mb-4">
                <div class="brand-badge p-2 rounded-3 bg-primary shadow mb-3">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 50px;">
                </div>
                <div>
                    <h1 class="h3 mb-1 text-white">Postgraduate Studies — Application</h1>
                    <p class="text-info">Upload your academic credentials to join our Master's programs.</p>
                </div>
            </div>

            <section class="panel p-3 p-md-4 rounded-3" style="background: rgba(255, 255, 255, 0.02);">
                <h3 class="h5 mb-4 border-bottom pb-2" style="color:var(--orange); font-weight:700;">Required Documents</h3>

                <form id="pgForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-light">Full Name</label>
                            <input type="text" class="form-control bg-dark border-secondary text-white" placeholder="Enter your full name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-light">National ID</label>
                            <input type="text" class="form-control bg-dark border-secondary text-white" placeholder="14-digit ID" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-light">College</label>
                            <select id="collegeSelect" class="form-select bg-dark border-secondary text-white" required onchange="updateMasterPrograms()">
                                <option value="">Choose College...</option>
                                <option value="industrial">Industrial Technology & Energy</option>
                                <option value="health">Health Sciences</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-light">Master's Program</label>
                            <select id="programSelect" class="form-select bg-dark border-secondary text-white" required disabled>
                                <option value="">Select Program...</option>
                            </select>
                        </div>
                    </div>

                    <div class="doc-list mt-4 p-3 rounded" style="background: rgba(255, 255, 255, 0.03);">
                        <div class="mb-3">
                            <label class="form-label d-block small"><i class="fa-solid fa-file-lines text-warning me-2"></i> Bachelor’s Degree Certificate</label>
                            <input type="file" class="form-control form-control-sm bg-dark border-secondary text-white" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block small"><i class="fa-solid fa-certificate text-warning me-2"></i> Academic Transcript (Full Years)</label>
                            <input type="file" class="form-control form-control-sm bg-dark border-secondary text-white" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block small"><i class="fa-solid fa-id-card text-warning me-2"></i> Curriculum Vitae (CV)</label>
                            <input type="file" class="form-control form-control-sm bg-dark border-secondary text-white" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block small"><i class="fa-solid fa-image text-warning me-2"></i> Recent Personal Photos (4x6)</label>
                            <input type="file" class="form-control form-control-sm bg-dark border-secondary text-white" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block small"><i class="fa-solid fa-image text-warning me-2"></i> Recommendation Letters</label>
                            <input type="file" class="form-control form-control-sm bg-dark border-secondary text-white" required>
                        </div>
                    </div>



                    <div class="col-12 d-grid mt-4 gap-2">
                        <button type="submit" class="btn btn-warning fw-bold py-2 rounded-pill shadow">Submit All Documents</button>
                        <button type="button" class="btn btn-outline-light py-2 rounded-pill" onclick="history.back()">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back
                        </button>
                    </div>
                </form>
            </section>
        </main>
    </div>
</div>

@push('scripts')
<script>
    function updateMasterPrograms() {
        const college = document.getElementById('collegeSelect').value;
        const programSelect = document.getElementById('programSelect');

        const programs = {
            'industrial': [
                'Master in Information Technology',
                'Master in Mechatronics',
                'Master in Renewable Energy',
                'Master in Autotronics',
                'Master in Petroleum'
            ],
            'health': [
                'Master in Prosthetics & Orthotics'
            ]
        };

        programSelect.innerHTML = '<option value="">Select Program...</option>';

        if (college && programs[college]) {
            programSelect.disabled = false;
            programs[college].forEach(prog => {
                let opt = document.createElement('option');
                opt.text = prog;
                opt.value = prog;
                programSelect.add(opt);
            });
        } else {
            programSelect.disabled = true;
        }
    }

    document.getElementById('pgForm').onsubmit = (e) => {
        e.preventDefault();
        alert("Your postgraduate documents have been successfully submitted!");
    };
</script>
@endpush

@push('styles')
<style>
    .apply-wrap {
        max-width: 850px;
        margin: 0 auto;
    }
    .form-control:focus, .form-select:focus {
        background: #0a1435 !important;
        border-color: var(--orange) !important;
        color: #fff !important;
        box-shadow: none;
    }
    .doc-list label { color: #bfcff8; }
</style>
@endpush

@endsection
