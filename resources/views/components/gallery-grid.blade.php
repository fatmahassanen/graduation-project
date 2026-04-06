<div class="container-xxl py-5">
    <div class="container">
        @if($title)
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Gallery</h6>
                <h1 class="mb-5">{{ $title }}</h1>
            </div>
        @endif

        <div class="row g-4">
            @foreach($images as $index => $image)
                <div class="{{ $getColumnClass() }} wow fadeInUp" data-wow-delay="{{ ($index * 0.1) + 0.1 }}s">
                    <div class="gallery-item position-relative overflow-hidden rounded">
                        <img class="img-fluid w-100" 
                             src="{{ asset($image['url']) }}" 
                             alt="{{ $image['title'] ?? $image['alt'] ?? 'Gallery Image' }}"
                             style="height: 250px; object-fit: cover; cursor: pointer;"
                             loading="lazy"
                             data-lightbox-url="{{ asset($image['url']) }}"
                             data-lightbox-title="{{ $image['title'] ?? '' }}"
                             data-lightbox-description="{{ $image['description'] ?? '' }}"
                             onclick="openLightbox(this)">
                        <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3">
                            @if(isset($image['title']))
                                <h6 class="text-white mb-1">{{ $image['title'] }}</h6>
                            @endif
                            @if(isset($image['description']))
                                <small class="text-white-50">{{ $image['description'] }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Lightbox Modal --}}
<div id="lightbox" class="modal fade" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" style="z-index: 1051;"></button>
                <img id="lightbox-img" src="" alt="" class="img-fluid w-100 rounded">
                <div class="text-center mt-3">
                    <h5 id="lightbox-title" class="text-white"></h5>
                    <p id="lightbox-description" class="text-white-50"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openLightbox(imgElement) {
    const url = imgElement.getAttribute('data-lightbox-url');
    const title = imgElement.getAttribute('data-lightbox-title');
    const description = imgElement.getAttribute('data-lightbox-description');
    
    document.getElementById('lightbox-img').src = url;
    document.getElementById('lightbox-title').textContent = title;
    document.getElementById('lightbox-description').textContent = description;
    
    var lightboxModal = new bootstrap.Modal(document.getElementById('lightbox'));
    lightboxModal.show();
}
</script>

<style>
.gallery-item {
    transition: transform 0.3s;
}
.gallery-item:hover {
    transform: scale(1.05);
}
.gallery-overlay {
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%);
    opacity: 0;
    transition: opacity 0.3s;
}
.gallery-item:hover .gallery-overlay {
    opacity: 1;
}
#lightbox .modal-dialog {
    max-width: 90%;
}
#lightbox .modal-content {
    background: rgba(0, 0, 0, 0.95) !important;
}
</style>
