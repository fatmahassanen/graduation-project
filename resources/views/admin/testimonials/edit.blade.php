@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <x-admin.page-header 
        title="Edit Testimonial" 
        description="Update graduate success story"
    />

    <x-admin.card>
        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Student Name -->
            <div class="mb-6">
                <label for="student_name" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user text-blue-600 mr-2"></i>Student Name *
                </label>
                <input 
                    type="text" 
                    name="student_name" 
                    id="student_name"
                    value="{{ old('student_name', $testimonial->student_name) }}"
                    required
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 p-3"
                    placeholder="e.g., Fatima (Tomi)"
                >
                @error('student_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Department -->
            <div class="mb-6">
                <label for="department" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-building text-green-600 mr-2"></i>Department
                </label>
                <input 
                    type="text" 
                    name="department" 
                    id="department"
                    value="{{ old('department', $testimonial->department) }}"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200 p-3"
                    placeholder="e.g., ICT Department"
                >
                @error('department')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Testimonial/Success Story -->
            <div class="mb-6">
                <label for="testimonial" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-quote-left text-yellow-600 mr-2"></i>Success Story *
                </label>
                <textarea 
                    name="testimonial" 
                    id="testimonial"
                    rows="4"
                    required
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 p-3"
                    placeholder="Enter the graduate's success story or testimonial..."
                >{{ old('testimonial', $testimonial->testimonial) }}</textarea>
                @error('testimonial')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Photo -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-image text-pink-600 mr-2"></i>Current Photo
                </label>
                @if($testimonial->photo)
                    <div class="mb-3">
                        <img src="{{ asset($testimonial->photo) }}" alt="{{ $testimonial->student_name }}" style="object-fit: contain; max-width: 100%; max-height: 100%; border-radius: 12px; background: #f8f9fa; width: 128px; height: 128px;">
                    </div>
                @else
                    <div class="mb-3">
                        <div class="w-32 h-32 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-graduate text-orange-600 text-4xl"></i>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">No photo uploaded</p>
                    </div>
                @endif
                
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                    Change Photo (optional)
                </label>
                <input 
                    type="file" 
                    name="photo" 
                    id="photo"
                    accept="image/*"
                    data-vibe-crop="true"
                    data-vibe-aspect-ratio="1"
                    data-vibe-crop-width="400"
                    data-vibe-crop-height="400"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all duration-200 p-2.5"
                >
                <div id="photo_preview" class="mt-3 hidden">
                    <img id="photo_preview_img" src="" alt="Preview" style="object-fit: contain; max-width: 100%; max-height: 100%; border-radius: 12px; background: #f8f9fa; width: 120px; height: 120px;">
                </div>
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Leave empty to keep current photo. Recommended: Square image (e.g., 400x400px). Supported formats: JPEG, PNG, JPG, GIF, WEBP (Max: 2MB)</p>
            </div>

            <!-- Display Order -->
            <div class="mb-6">
                <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-sort-numeric-down text-indigo-600 mr-2"></i>Display Order
                </label>
                <input 
                    type="number" 
                    name="order" 
                    id="order"
                    value="{{ old('order', $testimonial->order) }}"
                    required
                    min="0"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 p-3"
                    placeholder="1"
                >
                <p class="text-sm text-gray-500 mt-1">Lower numbers appear first. You can also drag-and-drop on the main page to reorder.</p>
                @error('order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        id="is_active"
                        value="1"
                        {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                    >
                    <span class="ml-3 text-sm font-medium text-gray-700">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>Active (Display on homepage)
                    </span>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg shadow-lg hover:from-green-700 hover:to-green-800 transform hover:scale-105 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Update Testimonial
                </button>
            </div>
        </form>
    </x-admin.card>
</div>
@endsection

@push('scripts')
@include('components.vibe-cropper-assets')
<script>
document.getElementById('photo')?.addEventListener('vibe-cropper:done', function (event) {
    const preview = document.getElementById('photo_preview');
    const previewImg = document.getElementById('photo_preview_img');
    if (preview && previewImg && event.detail.file) {
        previewImg.src = URL.createObjectURL(event.detail.file);
        preview.classList.remove('hidden');
    }
});
</script>
@endpush
