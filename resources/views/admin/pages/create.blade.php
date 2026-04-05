@extends('admin.layouts.app')

@section('title', 'Create Page')
@section('page-title', 'Create New Page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Page Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pages.store') }}" method="POST" id="pageForm">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug') }}">
                            <small class="text-muted">Leave empty to auto-generate from title</small>
                            @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="admissions" {{ old('category') === 'admissions' ? 'selected' : '' }}>Admissions</option>
                                    <option value="faculties" {{ old('category') === 'faculties' ? 'selected' : '' }}>Faculties</option>
                                    <option value="events" {{ old('category') === 'events' ? 'selected' : '' }}>Events</option>
                                    <option value="about" {{ old('category') === 'about' ? 'selected' : '' }}>About</option>
                                    <option value="quality" {{ old('category') === 'quality' ? 'selected' : '' }}>Quality</option>
                                    <option value="media" {{ old('category') === 'media' ? 'selected' : '' }}>Media</option>
                                    <option value="campus" {{ old('category') === 'campus' ? 'selected' : '' }}>Campus</option>
                                    <option value="staff" {{ old('category') === 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="student_services" {{ old('category') === 'student_services' ? 'selected' : '' }}>Student Services</option>
                                </select>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="language" class="form-label">Language <span class="text-danger">*</span></label>
                                <select class="form-select @error('language') is-invalid @enderror" 
                                        id="language" name="language" required>
                                    <option value="en" {{ old('language', 'en') === 'en' ? 'selected' : '' }}>English</option>
                                    <option value="ar" {{ old('language') === 'ar' ? 'selected' : '' }}>Arabic</option>
                                </select>
                                @error('language')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- SEO Meta Fields -->
                        <hr class="my-4">
                        <h6 class="mb-3">SEO Metadata</h6>

                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                   id="meta_title" name="meta_title" value="{{ old('meta_title') }}" maxlength="255">
                            <small class="text-muted">Leave empty to use page title</small>
                            @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                      id="meta_description" name="meta_description" rows="3" maxlength="160">{{ old('meta_description') }}</textarea>
                            <small class="text-muted"><span id="metaDescCount">0</span>/160 characters</small>
                            @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}">
                            <small class="text-muted">Comma-separated keywords</small>
                            @error('meta_keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="og_image" class="form-label">OG Image URL</label>
                            <input type="text" class="form-control @error('og_image') is-invalid @enderror" 
                                   id="og_image" name="og_image" value="{{ old('og_image') }}">
                            <small class="text-muted">Open Graph image for social media sharing</small>
                            @error('og_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Publish</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" form="pageForm">
                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" form="pageForm" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Page
                        </button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Help</h5>
                </div>
                <div class="card-body">
                    <p class="small mb-2"><strong>Title:</strong> The main heading of your page</p>
                    <p class="small mb-2"><strong>Slug:</strong> URL-friendly version of the title</p>
                    <p class="small mb-2"><strong>Category:</strong> Organize pages by section</p>
                    <p class="small mb-0"><strong>Status:</strong> Control page visibility</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        document.getElementById('slug').value = slug;
    });

    // Character counter for meta description
    const metaDesc = document.getElementById('meta_description');
    const metaDescCount = document.getElementById('metaDescCount');
    
    metaDesc.addEventListener('input', function() {
        metaDescCount.textContent = this.value.length;
    });
    
    // Initialize count
    metaDescCount.textContent = metaDesc.value.length;
</script>
@endpush
@endsection
