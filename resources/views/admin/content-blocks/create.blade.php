@extends('admin.layouts.app')

@section('title', 'Create Content Block')
@section('page-title', 'Create Content Block')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Content Block Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.content-blocks.store') }}" method="POST" id="blockForm">
                        @csrf

                        @if($page)
                        <input type="hidden" name="page_id" value="{{ $page->id }}">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Creating block for page: <strong>{{ $page->title }}</strong>
                        </div>
                        @else
                        <div class="mb-3">
                            <label for="page_id" class="form-label">Page <span class="text-danger">*</span></label>
                            <select class="form-select @error('page_id') is-invalid @enderror" 
                                    id="page_id" name="page_id" required>
                                <option value="">Select Page</option>
                                @foreach(\App\Models\Page::orderBy('title')->get() as $p)
                                <option value="{{ $p->id }}" {{ old('page_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->title }} ({{ $p->language }})
                                </option>
                                @endforeach
                            </select>
                            @error('page_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="type" class="form-label">Block Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="hero" {{ old('type') === 'hero' ? 'selected' : '' }}>Hero Section</option>
                                <option value="text" {{ old('type') === 'text' ? 'selected' : '' }}>Text Content</option>
                                <option value="card_grid" {{ old('type') === 'card_grid' ? 'selected' : '' }}>Card Grid</option>
                                <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video Embed</option>
                                <option value="faq" {{ old('type') === 'faq' ? 'selected' : '' }}>FAQ Section</option>
                                <option value="testimonial" {{ old('type') === 'testimonial' ? 'selected' : '' }}>Testimonials</option>
                                <option value="gallery" {{ old('type') === 'gallery' ? 'selected' : '' }}>Image Gallery</option>
                                <option value="contact_form" {{ old('type') === 'contact_form' ? 'selected' : '' }}>Contact Form</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('display_order') is-invalid @enderror" 
                                   id="display_order" name="display_order" value="{{ old('display_order', 0) }}" min="0">
                            <small class="text-muted">Lower numbers appear first</small>
                            @error('display_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Dynamic Content Fields -->
                        <div id="contentFields">
                            <p class="text-muted">Select a block type to see content fields</p>
                        </div>

                        <!-- Hero Block Template -->
                        <div id="hero-template" class="block-template" style="display: none;">
                            <h6 class="mb-3">Hero Section Content</h6>
                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="content[title]" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="content[description]" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Background Image URL</label>
                                <input type="text" class="form-control" name="content[image]">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">CTA Button Text</label>
                                    <input type="text" class="form-control" name="content[ctaText]">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">CTA Button Link</label>
                                    <input type="text" class="form-control" name="content[ctaLink]">
                                </div>
                            </div>
                        </div>

                        <!-- Text Block Template -->
                        <div id="text-template" class="block-template" style="display: none;">
                            <h6 class="mb-3">Text Content</h6>
                            <div class="mb-3">
                                <label class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control tinymce-editor" name="content[body]" rows="10"></textarea>
                                <small class="text-muted">Use the editor toolbar for formatting</small>
                            </div>
                        </div>

                        <!-- Card Grid Template -->
                        <div id="card_grid-template" class="block-template" style="display: none;">
                            <h6 class="mb-3">Card Grid Content</h6>
                            <div class="mb-3">
                                <label class="form-label">Number of Columns</label>
                                <select class="form-select" name="content[columns]">
                                    <option value="2">2 Columns</option>
                                    <option value="3" selected>3 Columns</option>
                                    <option value="4">4 Columns</option>
                                </select>
                            </div>
                            <div id="cardsContainer">
                                <div class="card mb-3 card-item">
                                    <div class="card-body">
                                        <h6>Card 1</h6>
                                        <div class="mb-2">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" name="content[cards][0][title]">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="content[cards][0][description]" rows="2"></textarea>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Image URL</label>
                                            <input type="text" class="form-control" name="content[cards][0][image]">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Link URL</label>
                                            <input type="text" class="form-control" name="content[cards][0][link]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary" id="addCard">
                                <i class="fas fa-plus"></i> Add Card
                            </button>
                        </div>

                        <!-- FAQ Template -->
                        <div id="faq-template" class="block-template" style="display: none;">
                            <h6 class="mb-3">FAQ Items</h6>
                            <div id="faqContainer">
                                <div class="card mb-3 faq-item">
                                    <div class="card-body">
                                        <h6>FAQ Item 1</h6>
                                        <div class="mb-2">
                                            <label class="form-label">Question</label>
                                            <input type="text" class="form-control" name="content[items][0][question]">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Answer</label>
                                            <textarea class="form-control" name="content[items][0][answer]" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary" id="addFaq">
                                <i class="fas fa-plus"></i> Add FAQ Item
                            </button>
                        </div>

                        <!-- Video Template -->
                        <div id="video-template" class="block-template" style="display: none;">
                            <h6 class="mb-3">Video Embed</h6>
                            <div class="mb-3">
                                <label class="form-label">Video URL (YouTube/Vimeo)</label>
                                <input type="text" class="form-control" name="content[url]">
                                <small class="text-muted">Enter the full video URL</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="content[title]">
                            </div>
                        </div>
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
                            <i class="fas fa-save"></i> Create Block
                        </button>
                        <a href="{{ $page ? route('admin.pages.edit', $page) : route('admin.pages.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Block Types</h5>
                </div>
                <div class="card-body">
                    <p class="small mb-2"><strong>Hero:</strong> Large banner with image and CTA</p>
                    <p class="small mb-2"><strong>Text:</strong> Rich text content with formatting</p>
                    <p class="small mb-2"><strong>Card Grid:</strong> Multiple cards in a grid layout</p>
                    <p class="small mb-2"><strong>Video:</strong> Embedded video player</p>
                    <p class="small mb-2"><strong>FAQ:</strong> Accordion-style Q&A section</p>
                    <p class="small mb-0"><strong>Gallery:</strong> Image gallery grid</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    // Block type switcher
    document.getElementById('type').addEventListener('change', function() {
        const type = this.value;
        const contentFields = document.getElementById('contentFields');
        const templates = document.querySelectorAll('.block-template');
        
        // Hide all templates
        templates.forEach(t => t.style.display = 'none');
        
        // Show selected template
        if (type) {
            const template = document.getElementById(type + '-template');
            if (template) {
                contentFields.innerHTML = '';
                contentFields.appendChild(template.cloneNode(true));
                contentFields.firstChild.style.display = 'block';
                
                // Initialize TinyMCE for text blocks
                if (type === 'text') {
                    initTinyMCE();
                }
            }
        }
    });

    // Add card functionality
    document.addEventListener('click', function(e) {
        if (e.target.id === 'addCard' || e.target.closest('#addCard')) {
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
        }

        if (e.target.classList.contains('remove-card')) {
            e.target.closest('.card-item').remove();
        }

        // Add FAQ functionality
        if (e.target.id === 'addFaq' || e.target.closest('#addFaq')) {
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
        }

        if (e.target.classList.contains('remove-faq')) {
            e.target.closest('.faq-item').remove();
        }
    });

    function initTinyMCE() {
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
    }
</script>
@endpush
@endsection
