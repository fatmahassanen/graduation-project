@extends('admin.layouts.app')

@section('title', 'Media Library')
@section('page-title', 'Media Library')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Media Files</h5>
            <a href="{{ route('admin.media.create') }}" class="btn btn-primary">
                <i class="fas fa-upload"></i> Upload Media
            </a>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" action="{{ route('admin.media.index') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search files..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="mime_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="image" {{ request('mime_type') === 'image' ? 'selected' : '' }}>Images</option>
                            <option value="application/pdf" {{ request('mime_type') === 'application/pdf' ? 'selected' : '' }}>PDFs</option>
                            <option value="document" {{ request('mime_type') === 'document' ? 'selected' : '' }}>Documents</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>

            <!-- Media Grid -->
            @if($media->count() > 0)
            <div class="row g-3">
                @foreach($media as $file)
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            @if(str_starts_with($file->mime_type, 'image/'))
                            <img src="{{ Storage::url($file->path) }}" class="img-fluid mb-2" alt="{{ $file->original_name }}" style="max-height: 150px; object-fit: cover;">
                            @else
                            <i class="fas fa-file fa-4x text-muted mb-2"></i>
                            @endif
                            <h6 class="card-title small">{{ Str::limit($file->original_name, 30) }}</h6>
                            <p class="card-text small text-muted">
                                {{ number_format($file->size / 1024, 2) }} KB<br>
                                {{ $file->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group btn-group-sm w-100" role="group">
                                <button class="btn btn-outline-primary copy-url" data-url="{{ Storage::url($file->path) }}" title="Copy URL">
                                    <i class="fas fa-copy"></i>
                                </button>
                                <form action="{{ route('admin.media.destroy', $file) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this file?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $media->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                <p class="text-muted">No media files yet. <a href="{{ route('admin.media.create') }}">Upload your first file</a></p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Copy URL functionality
    document.querySelectorAll('.copy-url').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.dataset.url;
            navigator.clipboard.writeText(url).then(() => {
                alert('URL copied to clipboard!');
            });
        });
    });
</script>
@endpush
@endsection
