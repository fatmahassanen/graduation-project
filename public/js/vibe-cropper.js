/**
 * Vibe Cropper — smart image upload pipeline with Cropper.js
 *
 * Required CDN assets (include once per page):
 * <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
 * <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
 */
window.VibeCropper = (function () {
    'use strict';

    // const DEFAULTS = {
    //     width: 400,
    //     height: 400,
    //     aspectRatio: 1,
    //     maxSizeBytes: 2 * 1024 * 1024,
    //     jpegQuality: 0.92,
    // };

    const DEFAULTS = {
    width: 400,
    height: 400,
    aspectRatio: NaN, // <--- هنا التغيير!
    maxSizeBytes: 2 * 1024 * 1024,
    jpegQuality: 0.92,
    };

    let cropper = null;
    let objectUrl = null;
    let activeInput = null;
    let activeConfig = null;
    let onDoneCallback = null;
    let originalFile = null;
    let originalFileName = 'image.jpg';

    function modal() {
        return document.getElementById('vibeCropModal');
    }

    function skipModal() {
        return document.getElementById('vibeSkipModal');
    }

    function cropImageEl() {
        return document.getElementById('vibeCropperImage');
    }

    function skipPreviewEl() {
        return document.getElementById('vibeSkipPreviewImage');
    }

    function destroyCropper() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    function revokeObjectUrl() {
        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }
    }

    function hiddenInputFor(input) {
        const name = input.getAttribute('name') || input.id;
        const hiddenId = name + '_cropped';
        let hidden = document.getElementById(hiddenId);

        if (!hidden) {
            hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = name + '_cropped';
            hidden.id = hiddenId;
            hidden.value = '0';
            input.insertAdjacentElement('afterend', hidden);
        }

        return hidden;
    }

    function setFileOnInput(input, file) {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        input.files = dataTransfer.files;
    }

    function dispatchDone(input, file, cropped) {
        input.dispatchEvent(new CustomEvent('vibe-cropper:done', {
            bubbles: true,
            detail: { file, cropped },
        }));

        if (typeof onDoneCallback === 'function') {
            onDoneCallback(file, cropped);
        }
    }

    function closeAll() {
        destroyCropper();
        revokeObjectUrl();

        const img = cropImageEl();
        if (img) {
            img.src = '';
        }

        modal()?.classList.remove('is-open');
        skipModal()?.classList.remove('is-open');

        activeInput = null;
        activeConfig = null;
        onDoneCallback = null;
        originalFile = null;
    }

    function readDimensions(file) {
        return new Promise(function (resolve, reject) {
            const url = URL.createObjectURL(file);
            const img = new Image();

            img.onload = function () {
                URL.revokeObjectURL(url);
                resolve({ width: img.naturalWidth, height: img.naturalHeight });
            };

            img.onerror = function () {
                URL.revokeObjectURL(url);
                reject(new Error('Unable to read image dimensions'));
            };

            img.src = url;
        });
    }

    function dimensionsMatch(size, config) {
        return size.width === config.width && size.height === config.height;
    }

    function finishWithOriginal() {
        if (!activeInput || !originalFile) {
            closeAll();
            return;
        }

        const hidden = hiddenInputFor(activeInput);
        hidden.value = '0';
        setFileOnInput(activeInput, originalFile);

        const input = activeInput;
        const file = originalFile;
        closeAll();
        dispatchDone(input, file, false);
    }

    function openCropper() {
        skipModal()?.classList.remove('is-open');

        if (!originalFile) {
            return;
        }

        revokeObjectUrl();
        objectUrl = URL.createObjectURL(originalFile);

        const img = cropImageEl();
        img.src = objectUrl;
        modal()?.classList.add('is-open');

        destroyCropper();

        // const initCropper = function () {
        //     cropper = new Cropper(img, {
        //         aspectRatio: 1,
        //         viewMode: 1,
        //         dragMode: 'move',
        //         cropBoxResizable: false,
        //         autoCropArea: 0.9,
        //         responsive: true,
        //     });
        // };


        const initCropper = function () {
            cropper = new Cropper(img, {
                aspectRatio: NaN,
                viewMode: 1,
                dragMode: 'move',
                cropBoxResizable: true,
                autoCropArea: 0.9,
                responsive: true,
            });
        };

        if (img.complete) {
            initCropper();
        } else {
            img.onload = initCropper;
        }
    }

    function openSkipDialog() {
        if (!originalFile) {
            return;
        }

        revokeObjectUrl();
        objectUrl = URL.createObjectURL(originalFile);

        const preview = skipPreviewEl();
        if (preview) {
            preview.src = objectUrl;
        }

        const label = document.getElementById('vibeSkipDimensions');
        if (label) {
            label.textContent = activeConfig.width + ' × ' + activeConfig.height + ' px';
        }

        skipModal()?.classList.add('is-open');
    }

    function confirmCrop() {
        if (!cropper || !activeInput) {
            return;
        }

        cropper.getCroppedCanvas({
            width: activeConfig.width,
            height: activeConfig.height,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        }).toBlob(function (blob) {
            if (!blob) {
                return;
            }

            if (blob.size > activeConfig.maxSizeBytes) {
                alert(
                    'Cropped image is too large (max 2MB). Please zoom in on the crop area and try again. '
                );
                return;
            }

            const croppedFile = new File(
                [blob],
                originalFileName.replace(/\.[^.]+$/, '') + '_cropped.jpg',
                { type: 'image/jpeg' }
            );

            const hidden = hiddenInputFor(activeInput);
            hidden.value = '1';
            setFileOnInput(activeInput, croppedFile);

            const input = activeInput;
            closeAll();
            dispatchDone(input, croppedFile, true);
        }, 'image/jpeg', activeConfig.jpegQuality);
    }

    function cancelSelection() {
        if (activeInput) {
            activeInput.value = '';
            const hidden = hiddenInputFor(activeInput);
            hidden.value = '0';
        }

        closeAll();
    }

    function parseConfig(input) {
        const width = parseInt(input.dataset.vibeCropWidth || DEFAULTS.width, 10);
        const height = parseInt(input.dataset.vibeCropHeight || DEFAULTS.height, 10);
        const aspect = parseFloat(
            input.dataset.vibeCropAspect || input.dataset.vibeAspectRatio || (width / height)
        );

        return {
            width: Number.isFinite(width) ? width : DEFAULTS.width,
            height: Number.isFinite(height) ? height : DEFAULTS.height,
            aspectRatio: Number.isFinite(aspect) ? aspect : DEFAULTS.aspectRatio,
            maxSizeBytes: DEFAULTS.maxSizeBytes,
            jpegQuality: DEFAULTS.jpegQuality,
        };
    }

    async function handleFileSelect(input, file, callback) {
        if (!file || !file.type.startsWith('image/')) {
            return;
        }

        if (typeof Cropper === 'undefined') {
            console.error('VibeCropper: Cropper.js is not loaded.');
            return;
        }

        activeInput = input;
        activeConfig = parseConfig(input);
        onDoneCallback = callback || null;
        originalFile = file;
        originalFileName = file.name || 'image.jpg';

        try {
            const size = await readDimensions(file);

            if (dimensionsMatch(size, activeConfig)) {
                openSkipDialog();
            } else {
                openCropper();
            }
        } catch (error) {
            openCropper();
        }
    }

    function bindInput(input) {
        if (input.dataset.vibeCropBound === '1') {
            return;
        }

        input.dataset.vibeCropBound = '1';
        hiddenInputFor(input);

        input.addEventListener('change', function (event) {
            const file = event.target.files && event.target.files[0];
            if (!file) {
                hiddenInputFor(input).value = '0';
                return;
            }

            handleFileSelect(input, file);
        });
    }

    function init(root) {
        const scope = root || document;
        scope.querySelectorAll('[data-vibe-crop]').forEach(bindInput);
    }

    function open(file, options, callback) {
        const fakeInput = document.createElement('input');
        fakeInput.type = 'file';
        fakeInput.name = options?.name || 'image';
        fakeInput.dataset.vibeCropWidth = String(options?.width || DEFAULTS.width);
        fakeInput.dataset.vibeCropHeight = String(options?.height || DEFAULTS.height);
        fakeInput.dataset.vibeCropAspect = String(options?.aspectRatio || DEFAULTS.aspectRatio);

        handleFileSelect(fakeInput, file, callback);
    }

    document.getElementById('vibeCropConfirmBtn')?.addEventListener('click', confirmCrop);
    document.getElementById('vibeCropCancelBtn')?.addEventListener('click', cancelSelection);
    document.getElementById('vibeSkipUseOriginalBtn')?.addEventListener('click', finishWithOriginal);
    document.getElementById('vibeSkipCropAnywayBtn')?.addEventListener('click', openCropper);
    document.getElementById('vibeSkipCancelBtn')?.addEventListener('click', cancelSelection);

    modal()?.addEventListener('click', function (event) {
        if (event.target === modal()) {
            cancelSelection();
        }
    });

    skipModal()?.addEventListener('click', function (event) {
        if (event.target === skipModal()) {
            cancelSelection();
        }
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            init();
        });
    } else {
        init();
    }

    return {
        init,
        open,
        bindInput,
    };
})();
