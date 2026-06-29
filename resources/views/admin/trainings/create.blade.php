@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <x-admin.page-header 
        title="Add New Training" 
        description="Create a new training program"
    />

    <x-admin.card>
        <form action="{{ route('admin.trainings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-heading text-blue-600 mr-2"></i>Training Title *
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title"
                    value="{{ old('title') }}"
                    required
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 p-3"
                    placeholder="e.g., Advanced Web Development Workshop"
                >
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-align-left text-yellow-600 mr-2"></i>Description *
                </label>
                <textarea 
                    name="description" 
                    id="description"
                    rows="4"
                    required
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 p-3"
                    placeholder="Enter training description..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Training Images (4 Images) -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-images text-pink-600 mr-2"></i>Training Images (Up to 4 Images)
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Image 1 -->
                    <div>
                        <label for="image1" class="block text-sm font-medium text-gray-600 mb-2">Image 1</label>
                        <input 
                            type="file" 
                            name="image1" 
                            id="image1"
                            accept="image/*"
                            data-vibe-crop="true"
                            data-vibe-aspect-ratio="1"
                            data-vibe-crop-width="400"
                            data-vibe-crop-height="400"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all duration-200 p-2.5"
                        >
                        @error('image1')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image 2 -->
                    <div>
                        <label for="image2" class="block text-sm font-medium text-gray-600 mb-2">Image 2</label>
                        <input 
                            type="file" 
                            name="image2" 
                            id="image2"
                            accept="image/*"
                            data-vibe-crop="true"
                            data-vibe-aspect-ratio="1"
                            data-vibe-crop-width="400"
                            data-vibe-crop-height="400"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all duration-200 p-2.5"
                        >
                        @error('image2')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image 3 -->
                    <div>
                        <label for="image3" class="block text-sm font-medium text-gray-600 mb-2">Image 3</label>
                        <input 
                            type="file" 
                            name="image3" 
                            id="image3"
                            accept="image/*"
                            data-vibe-crop="true"
                            data-vibe-aspect-ratio="1"
                            data-vibe-crop-width="400"
                            data-vibe-crop-height="400"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all duration-200 p-2.5"
                        >
                        @error('image3')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image 4 -->
                    <div>
                        <label for="image4" class="block text-sm font-medium text-gray-600 mb-2">Image 4</label>
                        <input 
                            type="file" 
                            name="image4" 
                            id="image4"
                            accept="image/*"
                            data-vibe-crop="true"
                            data-vibe-aspect-ratio="1"
                            data-vibe-crop-width="400"
                            data-vibe-crop-height="400"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all duration-200 p-2.5"
                        >
                        @error('image4')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-2">Upload up to 4 images to showcase the training from different angles. Supported formats: JPEG, PNG, JPG, GIF, WEBP (Max: 2MB each)</p>
            </div>

            <!-- Instructor and Category -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="instructor" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-chalkboard-teacher text-green-600 mr-2"></i>Instructor
                    </label>
                    <input 
                        type="text" 
                        name="instructor" 
                        id="instructor"
                        value="{{ old('instructor') }}"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200 p-3"
                        placeholder="Instructor name"
                    >
                    @error('instructor')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tag text-indigo-600 mr-2"></i>Category
                    </label>
                    <select 
                        name="category" 
                        id="category"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 p-3"
                    >
                        <option value="">-- Select Category --</option>
                        <option value="Technical" {{ old('category') == 'Technical' ? 'selected' : '' }}>Technical</option>
                        <option value="Soft Skills" {{ old('category') == 'Soft Skills' ? 'selected' : '' }}>Soft Skills</option>
                        <option value="Leadership" {{ old('category') == 'Leadership' ? 'selected' : '' }}>Leadership</option>
                        <option value="Professional Development" {{ old('category') == 'Professional Development' ? 'selected' : '' }}>Professional Development</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Start and End Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>Start Date
                    </label>
                    <input 
                        type="date" 
                        name="start_date" 
                        id="start_date"
                        value="{{ old('start_date') }}"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 p-3"
                    >
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-check text-green-600 mr-2"></i>End Date
                    </label>
                    <input 
                        type="date" 
                        name="end_date" 
                        id="end_date"
                        value="{{ old('end_date') }}"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200 p-3"
                    >
                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Location, Duration, and Capacity -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>Location
                    </label>
                    <input 
                        type="text" 
                        name="location" 
                        id="location"
                        value="{{ old('location') }}"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 p-3"
                        placeholder="e.g., Room 101"
                    >
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-clock text-orange-600 mr-2"></i>Duration (hours)
                    </label>
                    <input 
                        type="number" 
                        name="duration" 
                        id="duration"
                        value="{{ old('duration') }}"
                        min="1"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 p-3"
                        placeholder="Hours"
                    >
                    @error('duration')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-users text-teal-600 mr-2"></i>Capacity
                    </label>
                    <input 
                        type="number" 
                        name="capacity" 
                        id="capacity"
                        value="{{ old('capacity') }}"
                        min="1"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 p-3"
                        placeholder="Max participants"
                    >
                    @error('capacity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        id="is_active"
                        value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                    >
                    <span class="ml-3 text-sm font-medium text-gray-700">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>Active (Display on website)
                    </span>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.trainings.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Save Training
                </button>
            </div>
        </form>
    </x-admin.card>
</div>
@endsection

@push('scripts')
@include('components.vibe-cropper-assets')
@endpush
