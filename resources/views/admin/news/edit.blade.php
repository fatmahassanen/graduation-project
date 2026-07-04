@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <x-admin.page-header title="Edit News" description="Update news article" />

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
        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror">
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                <textarea name="excerpt" id="excerpt" rows="8" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $news->excerpt) }}</textarea>
                @error('excerpt')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Content <span class="text-red-500">*</span>
                </label>
                <textarea name="content" id="content" rows="8" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror">{{ old('content', $news->content) }}</textarea>
                @error('content')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div> --}}

            @if($news->image)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <img src="{{ asset($news->image) }}" alt="{{ $news->title }}" style="object-fit: contain; max-width: 100%; max-height: 100%; border-radius: 12px; background: #f8f9fa; width: 192px; height: 192px;">
                </div>
            @endif

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $news->image ? 'Change Image (optional)' : 'Image' }}
                </label>
                <input type="file" name="image" id="image" accept="image/*"
                    data-vibe-crop
                    data-vibe-crop-width="400"
                    data-vibe-crop-height="400"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror">
                <div id="image_preview" class="mt-3 hidden">
                    <img id="image_preview_img" src="" alt="Preview" style="object-fit: contain; max-width: 100%; max-height: 100%; border-radius: 12px; background: #f8f9fa; width: 120px; height: 120px;">
                </div>
                <p class="mt-1 text-sm text-gray-500">{{ $news->image ? 'Leave empty to keep current image' : 'Optional. JPEG, PNG, JPG, GIF, WEBP (Max: 2MB)' }}</p>
                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Published Date</label>
                <input type="date" name="published_at" id="published_at" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d') : '') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('published_at') border-red-500 @enderror">
                @error('published_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center space-x-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $news->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_featured" class="ml-2 text-sm font-medium text-gray-700">Featured</label>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.news.index') }}">
                    <x-admin.button variant="outline">Cancel</x-admin.button>
                </a>
                <x-admin.button type="submit" variant="success" icon="fa-save">Update News</x-admin.button>
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
