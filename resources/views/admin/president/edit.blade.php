@extends('layouts.admin')

@section('admin_content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">President Page Management</h1>
            <p class="mt-1 text-sm text-gray-600">View and manage the University President profile</p>
        </div>
        <button 
            id="toggleEditBtn" 
            onclick="toggleEditMode()" 
            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-lg hover:bg-blue-700 transform hover:scale-105 transition-all duration-200"
        >
            <i class="fas fa-edit mr-2"></i>
            <span id="toggleBtnText">Edit Content</span>
        </button>
    </div>

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" class="mb-6" />
    @endif

    <!-- Preview Mode -->
    <div id="previewMode" class="space-y-6">
        <!-- Main Profile Card -->
        <x-admin.card>
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Image -->
                <div class="flex-shrink-0">
                    @if($president->image)
                        <img src="{{ asset($president->image) }}" alt="{{ $president->full_name }}" class="w-48 h-48 object-cover rounded-lg border-4 border-blue-200 shadow-lg">
                    @else
                        <div class="w-48 h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-gray-400 text-6xl"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Info -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $president->full_name ?? 'Not Set' }}</h2>
                    @if($president->title)
                        <p class="text-lg text-blue-600 font-semibold mb-1">{{ $president->title }}</p>
                    @endif
                    @if($president->position)
                        <p class="text-md text-gray-600 mb-4">{{ $president->position }}</p>
                    @endif
                    @if($president->welcome_text)
                        <div class="mt-4 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-600">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $president->welcome_text }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </x-admin.card>

        <!-- Education Card -->
        @if($president->education)
            <x-admin.card>
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-graduation-cap text-blue-600 mr-3"></i>
                    Education
                </h3>
                <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $president->education }}</div>
            </x-admin.card>
        @endif

        <!-- Postdoctoral Card -->
        @if($president->postdoctoral)
            <x-admin.card>
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-flask text-yellow-600 mr-3"></i>
                    Postdoctoral Missions
                </h3>
                <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $president->postdoctoral }}</div>
            </x-admin.card>
        @endif

        <!-- Administrative Card -->
        @if($president->administrative)
            <x-admin.card>
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-award text-orange-600 mr-3"></i>
                    Administrative History & Achievements
                </h3>
                <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $president->administrative }}</div>
            </x-admin.card>
        @endif
    </div>

    <!-- Edit Mode -->
    <div id="editMode" class="hidden">
        <x-admin.card>
            <form action="{{ route('admin.president.update') }}" method="POST" enctype="multipart/form-data">
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
                        value="{{ old('full_name', $president->full_name) }}"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 p-3"
                        placeholder="e.g., Professor Dr. Tarek Abdelmalak"
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
                        value="{{ old('title', $president->title) }}"
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
                        value="{{ old('position', $president->position) }}"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200 p-3"
                        placeholder="e.g., President of New Cairo Technological University"
                    >
                    @error('position')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- President Image -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-image text-pink-600 mr-2"></i>President Image
                    </label>
                    
                    @if($president->image)
                        <div class="mb-4">
                            <img src="{{ asset($president->image) }}" alt="Current President Image" class="w-32 h-32 object-cover rounded-lg border-2 border-pink-200 shadow-md">
                            <p class="text-sm text-gray-500 mt-2">Current image (will be replaced if you upload a new one)</p>
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
                    <p class="text-sm text-gray-500 mt-1">Recommended: Square image (e.g., 400x400px). Max size: 2MB</p>
                </div>

                <!-- Welcome Text -->
                <div class="mb-6">
                    <label for="welcome_text" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-comment-dots text-purple-600 mr-2"></i>Welcome Message
                    </label>
                    <textarea 
                        name="welcome_text" 
                        id="welcome_text"
                        rows="6"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 p-3"
                        placeholder="Enter the president's welcome message..."
                    >{{ old('welcome_text', $president->welcome_text) }}</textarea>
                    @error('welcome_text')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">This appears in the main president card with the image</p>
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
                    >{{ old('education', $president->education) }}</textarea>
                    @error('education')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Example: PhD (Mechanical Power Engineering), Shanghai University, China – 2002</p>
                </div>

                <!-- Postdoctoral -->
                <div class="mb-6">
                    <label for="postdoctoral" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-flask text-yellow-600 mr-2"></i>Postdoctoral Missions
                    </label>
                    <textarea 
                        name="postdoctoral" 
                        id="postdoctoral"
                        rows="4"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 p-3"
                        placeholder="Enter postdoctoral missions (use line breaks for multiple entries)..."
                    >{{ old('postdoctoral', $president->postdoctoral) }}</textarea>
                    @error('postdoctoral')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Example: 2003-2005: Scientific mission at KAIST, South Korea</p>
                </div>

                <!-- Administrative -->
                <div class="mb-6">
                    <label for="administrative" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-award text-orange-600 mr-2"></i>Administrative History & Achievements
                    </label>
                    <textarea 
                        name="administrative" 
                        id="administrative"
                        rows="8"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 p-3"
                        placeholder="Enter administrative history and achievements (use line breaks for multiple entries)..."
                    >{{ old('administrative', $president->administrative) }}</textarea>
                    @error('administrative')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Example: Consultant at Niaf Paper Products Company (2005-2006)</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                    <button type="button" onclick="toggleEditMode()" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </x-admin.card>
    </div>
</div>

<script>
function toggleEditMode() {
    const previewMode = document.getElementById('previewMode');
    const editMode = document.getElementById('editMode');
    const toggleBtn = document.getElementById('toggleEditBtn');
    const toggleBtnText = document.getElementById('toggleBtnText');
    
    if (previewMode.classList.contains('hidden')) {
        // Switch to preview mode
        previewMode.classList.remove('hidden');
        editMode.classList.add('hidden');
        toggleBtnText.textContent = 'Edit Content';
        toggleBtn.innerHTML = '<i class="fas fa-edit mr-2"></i><span id="toggleBtnText">Edit Content</span>';
    } else {
        // Switch to edit mode
        previewMode.classList.add('hidden');
        editMode.classList.remove('hidden');
        toggleBtnText.textContent = 'View Preview';
        toggleBtn.innerHTML = '<i class="fas fa-eye mr-2"></i><span id="toggleBtnText">View Preview</span>';
    }
}

// If there are validation errors, show edit mode by default
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        toggleEditMode();
    });
@endif
</script>
@endsection
