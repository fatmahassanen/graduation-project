{{-- Vibe Cropper assets: Cropper.js CDN + modal markup + initializer --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

<style>
    #vibeCropModal,
    #vibeSkipModal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 1050;
        background: rgba(0, 0, 0, 0.55);
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    #vibeCropModal.is-open,
    #vibeSkipModal.is-open {
        display: flex;
    }

    .vibe-crop-dialog {
        background: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        max-width: 640px;
        width: 100%;
        overflow: hidden;
    }

    .vibe-crop-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .vibe-crop-body {
        padding: 1rem 1.5rem;
        background: #f8f9fa;
    }

    .vibe-crop-container {
        max-height: 60vh;
        overflow: hidden;
        background: #212529;
    }

    .vibe-crop-container img,
    .vibe-skip-preview img {
        display: block;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 12px;
        background: #f8f9fa;
    }

    .vibe-crop-footer {
        padding: 1rem 1.5rem 1.5rem;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .vibe-crop-btn {
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.938rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .vibe-crop-btn-secondary {
        background: #f8f9fa;
        color: #495057;
        border: 1px solid #e9ecef;
    }

    .vibe-crop-btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
    }

    .vibe-skip-preview {
        display: flex;
        justify-content: center;
        padding: 0.5rem 0 1rem;
    }

    .vibe-skip-preview img {
        max-width: 220px;
        max-height: 220px;
    }
</style>

<div id="vibeSkipModal" role="dialog" aria-modal="true" aria-labelledby="vibeSkipModalTitle">
    <div class="vibe-crop-dialog">
        <div class="vibe-crop-header">
            <h4 id="vibeSkipModalTitle" style="margin: 0; font-size: 1.125rem; font-weight: 700; color: #212529;">
                Image Already Fits / الصورة بالحجم المطلوب
            </h4>
            <p style="margin: 0.375rem 0 0; font-size: 0.875rem; color: #6c757d;">
                Your image is already <strong id="vibeSkipDimensions">400 × 400 px</strong>.
                Use it as-is to keep the full image, or crop if you prefer.
            </p>
        </div>
        <div class="vibe-crop-body">
            <div class="vibe-skip-preview">
                <img id="vibeSkipPreviewImage" src="" alt="Preview" style="object-fit: contain; max-width: 100%; max-height: 100%; border-radius: 12px; background: #f8f9fa;">
            </div>
        </div>
        <div class="vibe-crop-footer">
            <button type="button" id="vibeSkipCancelBtn" class="vibe-crop-btn vibe-crop-btn-secondary">Cancel </button>
            <button type="button" id="vibeSkipCropAnywayBtn" class="vibe-crop-btn vibe-crop-btn-secondary">Crop Anyway </button>
            <button type="button" id="vibeSkipUseOriginalBtn" class="vibe-crop-btn vibe-crop-btn-primary">Use Original </button>
        </div>
    </div>
</div>

<div id="vibeCropModal" role="dialog" aria-modal="true" aria-labelledby="vibeCropModalTitle">
    <div class="vibe-crop-dialog">
        <div class="vibe-crop-header">
            <h4 id="vibeCropModalTitle" style="margin: 0; font-size: 1.125rem; font-weight: 700; color: #212529;">
                Crop Image
            </h4>
            <p style="margin: 0.375rem 0 0; font-size: 0.875rem; color: #6c757d;">
                Drag to adjust the crop area.
            </p>
        </div>
        <div class="vibe-crop-body">
            <div class="vibe-crop-container">
                <img id="vibeCropperImage" src="" alt="Photo to crop">
            </div>
        </div>
        <div class="vibe-crop-footer">
            <button type="button" id="vibeCropCancelBtn" class="vibe-crop-btn vibe-crop-btn-secondary">Cancel</button>
            <button type="button" id="vibeCropConfirmBtn" class="vibe-crop-btn vibe-crop-btn-primary">Confirm Crop </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="{{ asset('js/vibe-cropper.js') }}"></script>
