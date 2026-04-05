@extends('admin.layouts.app')

@section('title', 'Edit Event')
@section('page-title', 'Edit Event')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.events.update', $event) }}" method="POST" id="eventForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $event->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description', $event->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" required>
                                @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" required>
                                @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $event->location) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="competition" {{ old('category', $event->category) === 'competition' ? 'selected' : '' }}>Competition</option>
                                    <option value="conference" {{ old('category', $event->category) === 'conference' ? 'selected' : '' }}>Conference</option>
                                    <option value="exhibition" {{ old('category', $event->category) === 'exhibition' ? 'selected' : '' }}>Exhibition</option>
                                    <option value="workshop" {{ old('category', $event->category) === 'workshop' ? 'selected' : '' }}>Workshop</option>
                                    <option value="seminar" {{ old('category', $event->category) === 'seminar' ? 'selected' : '' }}>Seminar</option>
                                </select>
                                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image_id" class="form-label">Featured Image</label>
                            <select class="form-select" id="image_id" name="image_id">
                                <option value="">No Image</option>
                                @foreach(\App\Models\Media::where('mime_type', 'like', 'image%')->get() as $media)
                                <option value="{{ $media->id }}" {{ old('image_id', $event->image_id) == $media->id ? 'selected' : '' }}>
                                    {{ $media->original_name }}
                                </option>
                                @endforeach
                            </select>
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
                        <select class="form-select" id="status" name="status" form="eventForm">
                            <option value="draft" {{ old('status', $event->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $event->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="language" class="form-label">Language</label>
                        <select class="form-select" id="language" name="language" form="eventForm">
                            <option value="en" {{ old('language', $event->language) === 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ old('language', $event->language) === 'ar' ? 'selected' : '' }}>Arabic</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" form="eventForm" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Event
                        </button>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
