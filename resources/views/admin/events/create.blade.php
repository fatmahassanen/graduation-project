@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <x-admin.page-header title="Add New Event" description="Create a new university event" />

    @if($errors->any())
        <x-admin.alert type="error">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-admin.alert>
    @endif

    <x-admin.card>
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror">
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea name="description" id="description" rows="4" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                    data-vibe-crop
                    data-vibe-crop-width="400"
                    data-vibe-crop-height="400"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror">
                <div id="image_preview" class="mt-3 hidden">
                    <img id="image_preview_img" src="" alt="Preview" style="object-fit: contain; max-width: 100%; max-height: 100%; border-radius: 12px; background: #f8f9fa; width: 120px; height: 120px;">
                </div>
                <p class="mt-1 text-sm text-gray-500">Supported formats: JPEG, PNG, JPG, GIF, WEBP (Max: 2MB)</p>
                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="link" class="block text-sm font-medium text-gray-700 mb-2">Event Link</label>
                <input type="url" name="link" id="link" value="{{ old('link') }}" placeholder="https://example.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('link') border-red-500 @enderror">
                @error('link')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.events.index') }}">
                    <x-admin.button variant="outline">Cancel</x-admin.button>
                </a>
                <x-admin.button type="submit" variant="success" icon="fa-save">Save Event</x-admin.button>
            </div>
        </form>
    </x-admin.card>
</div>
@endsection

@push('scripts')
@include('components.vibe-cropper-assets')
<script>
document.getElementById('image')?.addEventListener('vibe-cropper:done', function (event) {
    const preview = document.getElementById('image_preview');
    const previewImg = document.getElementById('image_preview_img');
    if (preview && previewImg && event.detail.file) {
        previewImg.src = URL.createObjectURL(event.detail.file);
        preview.classList.remove('hidden');
    }
});
</script>
@endpush
