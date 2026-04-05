@extends('admin.layouts.app')

@section('title', 'Upload Media')
@section('page-title', 'Upload Media')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Upload New File</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        <div class="mb-4">
                            <label for="file" class="form-label">Select File <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                   id="file" name="file" required accept="image/*,.pdf,.doc,.docx">
                            <small class="text-muted">
                                Allowed types: JPG, PNG, GIF, SVG, PDF, DOC, DOCX (Max: 10MB)
                            </small>
                            @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="alt_text" class="form-label">Alt Text (for images)</label>
                            <input type="text" class="form-control @error('alt_text') is-invalid @enderror" 
                                   id="alt_text" name="alt_text" value="{{ old('alt_text') }}">
                            <small class="text-muted">Describe the image for accessibility</small>
                            @error('alt_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Preview -->
                        <div id="filePreview" class="mb-4" style="display: none;">
                            <label class="form-label">Preview:</label>
                            <div class="border rounded p-3 text-center">
                                <img id="previewImage" src="" alt="Preview" class="img-fluid" style="max-height: 300px;">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Upload File
                            </button>
                            <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Upload Guidelines</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Maximum file size: 10MB</li>
                        <li>Supported image formats: JPG, JPEG, PNG, GIF, SVG</li>
                        <li>Supported document formats: PDF, DOC, DOCX</li>
                        <li>Use descriptive filenames for better organization</li>
                        <li>Add alt text for images to improve accessibility</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // File preview
    document.getElementById('file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('filePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('filePreview').style.display = 'none';
        }
    });
</script>
@endpush
@endsection
