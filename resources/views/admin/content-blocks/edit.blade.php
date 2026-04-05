@extends('admin.layouts.app')

@section('title', 'Edit Content Block')
@section('page-title', 'Edit Content Block')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit {{ ucfirst($contentBlock->type) }} Block</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.content-blocks.update', $contentBlock) }}" method="POST" id="blockForm">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="page_id" value="{{ $contentBlock->page_id }}">
                        <input type="hidden" name="type" value="{{ $contentBlock->type }}">

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Editing block for page: <strong>{{ $contentBlock->page->title }}</strong>
                        </div>

                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('display_order') is-invalid @enderror" 
                                   id="display_order" name="display_order" value="{{ old('display_order', $contentBlock->display_order) }}" min="0">
                            @error('display_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Hero Block -->
                        @if($contentBlock->type === 'hero')
                        <h6 class="mb-3">Hero Section Content</h6>
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="content[title]" 
                                   value="{{ old('content.title', $contentBlock->content['title'] ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="content[description]" rows="3">{{ old('content.description', $contentBlock->content['description'] ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Background Image URL</label>
                            <input type="text" class="form-control" name="content[image]" 
                                   value="{{ old('content.image', $contentBlock->content['image'] ?? '') }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CTA Button Text</label>
                                <input type="text" class="form-control" name="content[ctaText]" 
                                       value="{{ old('content.ctaText', $contentBlock->content['ctaText'] ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CTA Button Link</label>
                                <input type="text" class="form-control" name="content[ctaLink]" 
                                       value="{{ old('content.ctaLink', $contentBlock->content['ctaLink'] ?? '') }}">
                            </div>
                        </div>
                        @endif

                        <!-- Text Block -->
                        @if($contentBlock->type === 'text')
                        <h6 class="mb-3">Text Content</h6>
                        <div class="mb-3">
                            <label class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control tinymce-editor" name="content[body]" rows="10">{{ old('content.body', $contentBlock->content['body'] ?? '') }}</textarea>
                        </div>
                        @endif

                        <!-- Card Grid Block -->
                        @if($contentBlock->type === 'card_grid')
                        <h6 class="mb-3">Card Grid Content</h6>
                        <div class="mb-3">
                            <label class="form-label">Number of Columns</label>
                            <select class="form-select" name="content[columns]">
                                <option value="2" {{ ($contentBlock->content['columns'] ?? 3) == 2 ? 'selected' : '' }}>2 Columns</option>
                                <option value="3" {{ ($contentBlock->content['columns'] ?? 3) == 3 ? 'selected' : '' }}>3 Columns</option>
                                <option value="4" {{ ($contentBlock->content['columns'] ?? 3) == 4 ? 'selected' : '' }}>4 Columns</option>
                            </select>
                        </div>
                        <div id="cardsContainer">
                            @foreach(($contentBlock->content['cards'] ?? []) as $index => $card)
                            <div class="card mb-3 card-item">
                                <div class="card-body">
                                    <h6>Card {{ $index + 1 }}</h6>
                                    <div class="mb-2">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="content[cards][{{ $index }}][title]" 
                                               value="{{ $card['title'] ?? '' }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="content[cards][{{ $index }}][description]" rows="2">{{ $card['description'] ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Image URL</label>
                                        <input type="text" class="form-control" name="content[cards][{{ $index }}][image]" 
                                               value="{{ $card['image'] ?? '' }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Link URL</label>
                                        <input type="text" class="form-control" name="content[cards][{{ $index }}][link]" 
                                               value="{{ $card['link'] ?? '' }}">
                                    </div>
                                    @if($index > 0)
                                    <button type="button" class="btn btn-sm btn-danger remove-card">Remove</button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" id="addCard">
                            <i class="fas fa-plus"></i> Add Card
                        </button>
                        @endif

                        <!-- FAQ Block -->
                        @if($contentBlock->type === 'faq')
                        <h6 class="mb-3">FAQ Items</h6>
                        <div id="faqContainer">
                            @foreach(($contentBlock->content['items'] ?? []) as $index => $item)
                            <div class="card mb-3 faq-item">
                                <div class="card-body">
                                    <h6>FAQ Item {{ $index + 1 }}</h6>
                                    <div class="mb-2">
                                        <label class="form-label">Question</label>
                                        <input type="text" class="form-control" name="content[items][{{ $index }}][question]" 
                                               value="{{ $item['question'] ?? '' }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Answer</label>
                                        <textarea class="form-control" name="content[items][{{ $index }}][answer]" rows="3">{{ $item['answer'] ?? '' }}</textarea>
                                    </div>
                                    @if($index > 0)
                                    <button type="button" class="btn btn-sm btn-danger remove-faq">Remove</button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" id="addFaq">
                            <i class="fas fa-plus"></i> Add FAQ Item
                        </button>
                        @endif

                        <!-- Video Block -->
                        @if($contentBlock->type === 'video')
                        <h6 class="mb-3">Video Embed</h6>
                        <div class="mb-3">
                            <label class="form-label">Video URL (YouTube/Vimeo)</label>
                            <input type="text" class="form-control" name="content[url]" 
                                   value="{{ old('content.url', $contentBlock->content['url'] ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="content[title]" 
                                   value="{{ old('content.title', $contentBlock->content['title'] ?? '') }}">
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" form="blockForm" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Block
                        </button>
                        <a href="{{ route('admin.pages.edit', $contentBlock->page) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Page
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Block Info</h5>
                </div>
                <div class="card-body">
                    <p class="small mb-2"><strong>Type:</strong> {{ ucfirst($contentBlock->type) }}</p>
                    <p class="small mb-2"><strong>Created:</strong> {{ $contentBlock->created_at->format('M d, Y H:i') }}</p>
                    <p class="small mb-0"><strong>Updated:</strong> {{ $contentBlock->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    @if($contentBlock->type === 'text')
    // Initialize TinyMCE for text blocks
    tinymce.init({
        selector: '.tinymce-editor',
        height: 400,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
        content_style: 'body { font-family: Heebo, Arial, sans-serif; font-size: 14px; }'
    });
    @endif

    @if($contentBlock->type === 'card_grid')
    // Add card functionality
    document.getElementById('addCard').addEventListener('click', function() {
        const container = document.getElementById('cardsContainer');
        const count = container.querySelectorAll('.card-item').length;
        const newCard = document.createElement('div');
        newCard.className = 'card mb-3 card-item';
        newCard.innerHTML = `
            <div class="card-body">
                <h6>Card ${count + 1}</h6>
                <div class="mb-2">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="content[cards][${count}][title]">
                </div>
                <div class="mb-2">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="content[cards][${count}][description]" rows="2"></textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Image URL</label>
                    <input type="text" class="form-control" name="content[cards][${count}][image]">
                </div>
                <div class="mb-2">
                    <label class="form-label">Link URL</label>
                    <input type="text" class="form-control" name="content[cards][${count}][link]">
                </div>
                <button type="button" class="btn btn-sm btn-danger remove-card">Remove</button>
            </div>
        `;
        container.appendChild(newCard);
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-card')) {
            e.target.closest('.card-item').remove();
        }
    });
    @endif

    @if($contentBlock->type === 'faq')
    // Add FAQ functionality
    document.getElementById('addFaq').addEventListener('click', function() {
        const container = document.getElementById('faqContainer');
        const count = container.querySelectorAll('.faq-item').length;
        const newFaq = document.createElement('div');
        newFaq.className = 'card mb-3 faq-item';
        newFaq.innerHTML = `
            <div class="card-body">
                <h6>FAQ Item ${count + 1}</h6>
                <div class="mb-2">
                    <label class="form-label">Question</label>
                    <input type="text" class="form-control" name="content[items][${count}][question]">
                </div>
                <div class="mb-2">
                    <label class="form-label">Answer</label>
                    <textarea class="form-control" name="content[items][${count}][answer]" rows="3"></textarea>
                </div>
                <button type="button" class="btn btn-sm btn-danger remove-faq">Remove</button>
            </div>
        `;
        container.appendChild(newFaq);
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-faq')) {
            e.target.closest('.faq-item').remove();
        }
    });
    @endif
</script>
@endpush
@endsection
