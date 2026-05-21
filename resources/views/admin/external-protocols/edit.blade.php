@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <x-admin.page-header 
        title="Edit Protocol" 
        description="Update external cooperation protocol information"
    />

    <x-admin.card>
        <form action="{{ route('admin.external-protocols.update', $externalProtocol) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-heading text-blue-600 mr-2"></i>Protocol Title *
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title"
                    value="{{ old('title', $externalProtocol->title) }}"
                    required
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 p-3"
                    placeholder="e.g., Yangzhou University"
                >
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Organization Name -->
            <div class="mb-6">
                <label for="organization_name" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-building text-purple-600 mr-2"></i>Organization/Department
                </label>
                <input 
                    type="text" 
                    name="organization_name" 
                    id="organization_name"
                    value="{{ old('organization_name', $externalProtocol->organization_name) }}"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 p-3"
                    placeholder="e.g., College of Electrical & Energy Engineering"
                >
                @error('organization_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Year Dropdown -->
            <div class="mb-6">
                <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-calendar-alt text-green-600 mr-2"></i>Year *
                </label>
                <select 
                    name="year" 
                    id="year"
                    required
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200 p-3"
                >
                    <option value="">Select Year</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ old('year', $externalProtocol->year) == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
                @error('year')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Select the year this protocol was established</p>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-align-left text-yellow-600 mr-2"></i>Description
                </label>
                <textarea 
                    name="description" 
                    id="description"
                    rows="4"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 p-3"
                    placeholder="Enter protocol description..."
                >{{ old('description', $externalProtocol->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-image text-pink-600 mr-2"></i>Organization Logo/Image
                </label>
                
                @if($externalProtocol->image)
                    <div class="mb-4">
                        <img src="{{ asset($externalProtocol->image) }}" alt="Current Image" class="w-32 h-32 object-contain rounded-lg border-2 border-pink-200 shadow-md">
                        <p class="text-sm text-gray-500 mt-2">Current image</p>
                    </div>
                @endif

                <input 
                    type="file" 
                    name="image" 
                    id="image"
                    accept="image/*"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all duration-200 p-2.5"
                >
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Recommended: Logo or representative image. Max size: 2MB</p>
            </div>

            <!-- Order -->
            <div class="mb-6">
                <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-sort-numeric-down text-indigo-600 mr-2"></i>Display Order
                </label>
                <input 
                    type="number" 
                    name="order" 
                    id="order"
                    value="{{ old('order', $externalProtocol->order) }}"
                    min="0"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 p-3"
                    placeholder="0"
                >
                @error('order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Lower numbers appear first within the same year</p>
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        id="is_active"
                        value="1"
                        {{ old('is_active', $externalProtocol->is_active) ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                    >
                    <span class="ml-3 text-sm font-medium text-gray-700">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>Active (Display on website)
                    </span>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.external-protocols.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Update Protocol
                </button>
            </div>
        </form>
    </x-admin.card>
</div>
@endsection
