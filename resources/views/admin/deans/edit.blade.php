@extends('layouts.admin')

@section('admin_content')
<div class="max-w-7xl mx-auto">
    <x-admin.page-header 
        title="Edit Dean Profile" 
        description="Update the dean's complete profile information"
    />

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" class="mb-6" />
    @endif

    <x-admin.card>
        <form action="{{ route('admin.deans.update', $dean) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Full Name -->
            <div class="mb-6">
                <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user text-blue-600 mr-2"></i>Full Name & Title
                </label>
                <input 
                    type="text" 
                    name="full_name" 
                    id="full_name"
                    value="{{ old('full_name', $dean->full_name) }}"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 p-3"
                    placeholder="e.g., Professor Dr. Walid Al-Khatam"
                >
                @error('full_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-id-badge text-indigo-600 mr-2"></i>Academic Title
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title"
                    value="{{ old('title', $dean->title) }}"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 p-3"
                    placeholder="e.g., Professor, Dr., PhD"
                >
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Position -->
            <div class="mb-6">
                <label for="position" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-briefcase text-green-600 mr-2"></i>Current Position
                </label>
                <input 
                    type="text" 
                    name="position" 
                    id="position"
                    value="{{ old('position', $dean->position) }}"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200 p-3"
                    placeholder="e.g., Dean of Industrial and Energy Technology"
                >
                @error('position')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Faculty -->
            <div class="mb-6">
                <label for="faculty" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-building text-purple-600 mr-2"></i>Faculty/Department
                </label>
                <input 
                    type="text" 
                    name="faculty" 
                    id="faculty"
                    value="{{ old('faculty', $dean->faculty) }}"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 p-3"
                    placeholder="e.g., Faculty of Industrial and Energy Technology"
                >
                @error('faculty')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dean Image -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-image text-pink-600 mr-2"></i>Dean Image
                </label>
                
                @if($dean->image)
                    <div class="mb-4">
                        <img src="{{ asset($dean->image) }}" alt="Current Dean Image" style="object-fit: contain; max-width: 100%; max-height: 100%; border-radius: 12px; background: #f8f9fa; width: 192px; height: 192px;">
                        <p class="text-sm text-gray-500 mt-2">Current image</p>
                    </div>
                @endif

                <input 
                    type="file" 
                    name="image" 
                    id="image"
                    accept="image/*"
                    data-vibe-crop="true"
                    data-vibe-aspect-ratio="1"
                    data-vibe-crop-width="400"
                    data-vibe-crop-height="400"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all duration-200 p-2.5"
                >
                <div id="image_preview" class="mt-3 hidden">
                    <img id="image_preview_img" src="" alt="Preview" style="object-fit: contain; max-width: 100%; max-height: 100%; border-radius: 12px; background: #f8f9fa; width: 120px; height: 120px;">
                </div>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Recommended: Square image (e.g., 400x400px). Max size: 2MB</p>
            </div>

            <!-- Welcome Text -->
            <div class="mb-6">
                <label for="welcome_text" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-comment-dots text-yellow-600 mr-2"></i>Welcome Message
                </label>
                <textarea 
                    name="welcome_text" 
                    id="welcome_text"
                    rows="6"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 p-3"
                    placeholder="Enter the dean's welcome message..."
                >{{ old('welcome_text', $dean->welcome_text) }}</textarea>
                @error('welcome_text')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">This appears in the main dean card with the image</p>
            </div>

            <!-- Education -->
            <div class="mb-6">
                <label for="education" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>Education
                </label>
                <textarea 
                    name="education" 
                    id="education"
                    rows="6"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 p-3"
                    placeholder="Enter education details (use line breaks for multiple entries)..."
                >{{ old('education', $dean->education) }}</textarea>
                @error('education')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Example: PhD in Electrical Engineering, University of Waterloo, Canada – June 2005</p>
            </div>

            <!-- Professional Experience -->
            <div class="mb-6">
                <label for="experience" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-award text-orange-600 mr-2"></i>Professional Experience & Positions
                </label>
                <textarea 
                    name="experience" 
                    id="experience"
                    rows="8"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 p-3"
                    placeholder="Enter professional experience and positions (use line breaks for multiple entries)..."
                >{{ old('experience', $dean->experience) }}</textarea>
                @error('experience')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Example: Professor, Department of Electrical Power and Machines Engineering</p>
            </div>

            <!-- Order (Hidden field) -->
            <input type="hidden" name="order" value="{{ $dean->order }}">

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.deans.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>
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
