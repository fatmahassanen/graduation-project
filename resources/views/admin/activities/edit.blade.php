@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <x-admin.page-header title="Edit Activity" description="Update activity information" />

    <!-- Error Messages -->
    @if($errors->any())
        <x-admin.alert type="error">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-admin.alert>
    @endif

    <!-- Form Card -->
    <x-admin.card>
        <form action="{{ route('admin.activities.update', $activity) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title"
                    value="{{ old('title', $activity->title) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                    required
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="description" 
                    id="description"
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                    required
                >{{ old('description', $activity->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image -->
            @if($activity->image)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <img src="{{ $activity->image_url }}" alt="{{ $activity->title }}" style="object-fit: contain; max-width: 100%; max-height: 100%; border-radius: 12px; background: #f8f9fa; width: 192px; height: 192px;">
                </div>
            @endif

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $activity->image ? 'Change Image (optional)' : 'Image' }}
                </label>
                <input 
                    type="file" 
                    name="image" 
                    id="image"
                    accept="image/*"
                    data-vibe-crop="true"
                    data-vibe-aspect-ratio="1"
                    data-vibe-crop-width="400"
                    data-vibe-crop-height="400"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror"
                >
                <div id="image_preview" class="mt-3 hidden">
                    <img id="image_preview_img" src="" alt="Preview" style="object-fit: contain; max-width: 100%; max-height: 100%; border-radius: 12px; background: #f8f9fa; width: 120px; height: 120px;">
                </div>
                <p class="mt-1 text-sm text-gray-500">{{ $activity->image ? 'Leave empty to keep current image' : 'Supported formats: JPEG, PNG, JPG, GIF, WEBP (Max: 2MB)' }}</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select 
                    name="category" 
                    id="category"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror"
                >
                    <option value="">-- Select Category --</option>
                    <option value="Competition" {{ old('category', $activity->category) == 'Competition' ? 'selected' : '' }}>Competition</option>
                    <option value="Award" {{ old('category', $activity->category) == 'Award' ? 'selected' : '' }}>Award</option>
                    <option value="Innovation" {{ old('category', $activity->category) == 'Innovation' ? 'selected' : '' }}>Innovation</option>
                    <option value="International" {{ old('category', $activity->category) == 'International' ? 'selected' : '' }}>International</option>
                    <option value="Sustainability" {{ old('category', $activity->category) == 'Sustainability' ? 'selected' : '' }}>Sustainability</option>
                    <option value="Achievement" {{ old('category', $activity->category) == 'Achievement' ? 'selected' : '' }}>Achievement</option>
                    <option value="Sports" {{ old('category', $activity->category) == 'Sports' ? 'selected' : '' }}>Sports</option>
                    <option value="Social" {{ old('category', $activity->category) == 'Social' ? 'selected' : '' }}>Social</option>
                    <option value="Entrepreneurship" {{ old('category', $activity->category) == 'Entrepreneurship' ? 'selected' : '' }}>Entrepreneurship</option>
                    <option value="Community" {{ old('category', $activity->category) == 'Community' ? 'selected' : '' }}>Community</option>
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    name="is_active" 
                    id="is_active"
                    value="1"
                    {{ old('is_active', $activity->is_active) ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                >
                <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active</label>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.activities.index') }}">
                    <x-admin.button variant="outline">Cancel</x-admin.button>
                </a>
                <x-admin.button type="submit" variant="success" icon="fa-save">
                    Update Activity
                </x-admin.button>
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
