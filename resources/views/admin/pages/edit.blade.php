@extends('admin.layouts.app')

@section('title', 'Edit Page')
@section('page-title', 'Edit Page: ' . $page->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <!-- Page Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Page Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pages.update', $page) }}" method="POST" id="pageForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $page->title) }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug', $page->slug) }}">
                            @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" name="category" required>
                                    <option value="admissions" {{ old('category', $page->category) === 'admissions' ? 'selected' : '' }}>Admissions</option>
                                    <option value="faculties" {{ old('category', $page->category) === 'faculties' ? 'selected' : '' }}>Faculties</option>
                                    <option value="events" {{ old('category', $page->category) === 'events' ? 'selected' : '' }}>Events</option>
                                    <option value="about" {{ old('category', $page->category) === 'about' ? 'selected' : '' }}>About</option>
                                    <option value="quality" {{ old('category', $page->category) === 'quality' ? 'selected' : '' }}>Quality</option>
                                    <option value="media" {{ old('category', $page->category) === 'media' ? 'selected' : '' }}>Media</option>
                                    <option value="campus" {{ old('category', $page->category) === 'campus' ? 'selected' : '' }}>Campus</option>
                                    <option value="staff" {{ old('category', $page->category) === 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="student_services" {{ old('category', $page->category) === 'student_services' ? 'selected' : '' }}>Student Services</option>
                                </select>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="language" class="form-label">Language <span class="text-danger">*</span></label>
                                <select class="form-select @error('language') is-invalid @enderror" 
                                        id="language" name="language" required>
                                    <option value="en" {{ old('language', $page->language) === 'en' ? 'selected' : '' }}>English</option>
                                    <option value="ar" {{ old('language', $page->language) === 'ar' ? 'selected' : '' }}>Arabic</option>
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
                                   id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" maxlength="255">
                            @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                      id="meta_description" name="meta_description" rows="3" maxlength="160">{{ old('meta_description', $page->meta_description) }}</textarea>
                            <small class="text-muted"><span id="metaDescCount">0</span>/160 characters</small>
                            @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}">
                            @error('meta_keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="og_image" class="form-label">OG Image URL</label>
                            <input type="text" class="form-control @error('og_image') is-invalid @enderror" 
                                   id="og_image" name="og_image" value="{{ old('og_image', $page->og_image) }}">
                            @error('og_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>

            <!-- Content Blocks -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Content Blocks</h5>
                    <a href="{{ route('admin.content-blocks.create', ['page_id' => $page->id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add Block
                    </a>
                </div>
                <div class="card-body">
                    @if($page->contentBlocks->count() > 0)
                    <div id="contentBlocksList">
                        @foreach($page->contentBlocks as $block)
                        <div class="card mb-3 content-block-item" data-block-id="{{ $block->id }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <span class="badge bg-info">{{ ucfirst($block->type) }}</span>
                                            Block #{{ $block->id }}
                                        </h6>
                                        <small class="text-muted">Order: {{ $block->display_order }}</small>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary move-up" title="Move Up">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary move-down" title="Move Down">
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                        <a href="{{ route('admin.content-blocks.edit', $block) }}" class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.content-blocks.destroy', $block) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this block?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        @if($block->type === 'hero')
                                            Hero: {{ $block->content['title'] ?? 'No title' }}
                                        @elseif($block->type === 'text')
                                            Text Block
                                        @elseif($block->type === 'card_grid')
                                            Card Grid: {{ count($block->content['cards'] ?? []) }} cards
                                        @else
                                            {{ ucfirst($block->type) }} Block
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-th-large fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No content blocks yet. <a href="{{ route('admin.content-blocks.create', ['page_id' => $page->id]) }}">Add your first block</a></p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Publish Box -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Publish</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" form="pageForm">
                            <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status', $page->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">
                            <strong>Created:</strong> {{ $page->created_at->format('M d, Y H:i') }}<br>
                            <strong>Updated:</strong> {{ $page->updated_at->format('M d, Y H:i') }}<br>
                            @if($page->published_at)
                            <strong>Published:</strong> {{ $page->published_at->format('M d, Y H:i') }}
                            @endif
                        </small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" form="pageForm" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Page
                        </button>
                        
                        @if($page->status === 'draft')
                        <form action="{{ route('admin.pages.publish', $page) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check"></i> Publish Now
                            </button>
                        </form>
                        @elseif($page->status === 'published')
                        <form action="{{ route('admin.pages.unpublish', $page) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-pause"></i> Unpublish
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Pages
                        </a>
                    </div>
                </div>
            </div>

            <!-- Revisions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Revisions</h5>
                </div>
                <div class="card-body">
                    @if($page->revisions->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($page->revisions->take(5) as $revision)
                        <div class="list-group-item px-0">
                            <small>
                                <strong>{{ $revision->action }}</strong> by {{ $revision->user->name }}<br>
                                <span class="text-muted">{{ $revision->created_at->diffForHumans() }}</span>
                            </small>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('admin.revisions.index', ['revisionable_type' => get_class($page), 'revisionable_id' => $page->id]) }}" class="btn btn-sm btn-outline-secondary w-100 mt-2">
                        View All Revisions
                    </a>
                    @else
                    <p class="text-muted small mb-0">No revisions yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Character counter for meta description
    const metaDesc = document.getElementById('meta_description');
    const metaDescCount = document.getElementById('metaDescCount');
    
    metaDesc.addEventListener('input', function() {
        metaDescCount.textContent = this.value.length;
    });
    
    // Initialize count
    metaDescCount.textContent = metaDesc.value.length;

    // Content block reordering
    document.querySelectorAll('.move-up').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.content-block-item');
            const prev = item.previousElementSibling;
            if (prev) {
                item.parentNode.insertBefore(item, prev);
                updateBlockOrder();
            }
        });
    });

    document.querySelectorAll('.move-down').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.content-block-item');
            const next = item.nextElementSibling;
            if (next) {
                item.parentNode.insertBefore(next, item);
                updateBlockOrder();
            }
        });
    });

    function updateBlockOrder() {
        const blocks = document.querySelectorAll('.content-block-item');
        const order = Array.from(blocks).map(block => block.dataset.blockId);
        
        // Send AJAX request to update order
        fetch('{{ route("admin.content-blocks.reorder", $page) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ order: order })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Order updated successfully');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endpush
@endsection
