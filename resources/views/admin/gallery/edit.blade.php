@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <x-admin.page-header title="Edit Gallery Image" description="Update image information" />

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
        <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            @if($gallery->image)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->title }}" class="w-64 h-64 object-cover rounded-lg shadow-sm">
                </div>
            @endif

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $gallery->image ? 'Change Image (optional)' : 'Image' }}
                </label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">{{ $gallery->image ? 'Leave empty to keep current image' : 'Supported formats: JPEG, PNG, JPG, GIF, WEBP (Max: 2MB)' }}</p>
                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $gallery->title) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror">
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" id="category"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror">
                    <option value="">-- Select Category --</option>
                    <option value="Leadership" {{ old('category', $gallery->category) == 'Leadership' ? 'selected' : '' }}>Leadership</option>
                    <option value="Campus" {{ old('category', $gallery->category) == 'Campus' ? 'selected' : '' }}>Campus</option>
                    <option value="Events" {{ old('category', $gallery->category) == 'Events' ? 'selected' : '' }}>Events</option>
                    <option value="Projects" {{ old('category', $gallery->category) == 'Projects' ? 'selected' : '' }}>Projects</option>
                    <option value="Students" {{ old('category', $gallery->category) == 'Students' ? 'selected' : '' }}>Students</option>
                </select>
                @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active</label>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.gallery.index') }}">
                    <x-admin.button variant="outline">Cancel</x-admin.button>
                </a>
                <x-admin.button type="submit" variant="success" icon="fa-save">Update Image</x-admin.button>
            </div>
        </form>
    </x-admin.card>
</div>
@endsection
