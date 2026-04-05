@extends('admin.layouts.app')

@section('title', 'Create News')
@section('page-title', 'Create News Article')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.news.store') }}" method="POST" id="newsForm">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}">
                            <small class="text-muted">Leave empty to auto-generate</small>
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" name="excerpt" rows="3" required>{{ old('excerpt') }}</textarea>
                            @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="body" class="form-label">Body <span class="text-danger">*</span></label>
                            <textarea class="form-control tinymce-editor @error('body') is-invalid @enderror" 
                                      id="body" name="body" rows="15" required>{{ old('body') }}</textarea>
                            @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="announcement">Announcement</option>
                                    <option value="achievement">Achievement</option>
                                    <option value="research">Research</option>
                                    <option value="partnership">Partnership</option>
                                </select>
                                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="featured_image_id" class="form-label">Featured Image</label>
                                <select class="form-select" id="featured_image_id" name="featured_image_id">
                                    <option value="">No Image</option>
                                    @foreach(\App\Models\Media::where('mime_type', 'like', 'image%')->get() as $media)
                                    <option value="{{ $media->id }}">{{ $media->original_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Publish</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" form="newsForm">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="language" class="form-label">Language</label>
                        <select class="form-select" id="language" name="language" form="newsForm">
                            <option value="en">English</option>
                            <option value="ar">Arabic</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" form="newsForm">
                            <label class="form-check-label" for="is_featured">
                                Featured Article
                            </label>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" form="newsForm" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create News
                        </button>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Auto-generate slug
    document.getElementById('title').addEventListener('input', function() {
        const slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        document.getElementById('slug').value = slug;
    });

    // Initialize TinyMCE
    tinymce.init({
        selector: '.tinymce-editor',
        height: 500,
        menubar: false,
        plugins: ['advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media', 'table', 'help', 'wordcount'],
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
        content_style: 'body { font-family: Heebo, Arial, sans-serif; font-size: 14px; }'
    });
</script>
@endpush
@endsection
