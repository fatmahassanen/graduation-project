@extends('admin.layouts.app')

@section('title', 'Edit News')
@section('page-title', 'Edit News Article')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.news.update', $news) }}" method="POST" id="newsForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $news->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $news->slug) }}">
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" name="excerpt" rows="3" required>{{ old('excerpt', $news->excerpt) }}</textarea>
                            @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="body" class="form-label">Body <span class="text-danger">*</span></label>
                            <textarea class="form-control tinymce-editor @error('body') is-invalid @enderror" 
                                      id="body" name="body" rows="15" required>{{ old('body', $news->body) }}</textarea>
                            @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="announcement" {{ old('category', $news->category) === 'announcement' ? 'selected' : '' }}>Announcement</option>
                                    <option value="achievement" {{ old('category', $news->category) === 'achievement' ? 'selected' : '' }}>Achievement</option>
                                    <option value="research" {{ old('category', $news->category) === 'research' ? 'selected' : '' }}>Research</option>
                                    <option value="partnership" {{ old('category', $news->category) === 'partnership' ? 'selected' : '' }}>Partnership</option>
                                </select>
                                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="featured_image_id" class="form-label">Featured Image</label>
                                <select class="form-select" id="featured_image_id" name="featured_image_id">
                                    <option value="">No Image</option>
                                    @foreach(\App\Models\Media::where('mime_type', 'like', 'image%')->get() as $media)
                                    <option value="{{ $media->id }}" {{ old('featured_image_id', $news->featured_image_id) == $media->id ? 'selected' : '' }}>
                                        {{ $media->original_name }}
                                    </option>
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
                            <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="language" class="form-label">Language</label>
                        <select class="form-select" id="language" name="language" form="newsForm">
                            <option value="en" {{ old('language', $news->language) === 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ old('language', $news->language) === 'ar' ? 'selected' : '' }}>Arabic</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $news->is_featured) ? 'checked' : '' }} form="newsForm">
                            <label class="form-check-label" for="is_featured">Featured Article</label>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" form="newsForm" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update News
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
