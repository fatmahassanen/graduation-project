@extends('layouts.admin')

@section('admin_content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Competitions</h1>
            <p class="mt-1 text-sm text-gray-600">Manage competition cards and video</p>
        </div>
        <a href="{{ route('admin.competitions.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-lg shadow-lg hover:from-indigo-700 hover:to-indigo-800 transform hover:scale-105 transition-all duration-200">
            <i class="fas fa-plus mr-2"></i>
            Add New Competition
        </a>
    </div>

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" class="mb-6" />
    @endif

    <!-- Video URL Section -->
    <x-admin.card class="mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-video text-red-600 mr-2"></i>Competition Video URL
        </h2>
        <form action="{{ route('admin.competitions.update-video') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex gap-3">
                <input 
                    type="text" 
                    name="video_url" 
                    value="{{ $videoUrl }}"
                    class="flex-1 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 p-3"
                    placeholder="Enter video URL or path (e.g., {{ asset('img/videos/comptions.mp4') }})"
                    required
                >
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Update Video
                </button>
            </div>
            <p class="text-sm text-gray-500 mt-2">Enter the full URL or asset path for the competition video</p>
        </form>
    </x-admin.card>

    <!-- Competitions List -->
    <x-admin.card>
        @if($competitions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Image
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($competitions as $competition)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800">
                                        {{ $competition->order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($competition->image)
                                        <img src="{{ asset($competition->image) }}" alt="{{ $competition->title }}" class="w-16 h-16 rounded object-cover border border-gray-200">
                                    @else
                                        <div class="w-16 h-16 rounded bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($competition->title, 50) }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($competition->description, 60) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $competition->date }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($competition->is_active)
                                        <x-admin.badge type="success">Active</x-admin.badge>
                                    @else
                                        <x-admin.badge type="secondary">Inactive</x-admin.badge>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.competitions.edit', $competition) }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.competitions.destroy', $competition) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this competition?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-admin.empty-state 
                icon="fa-trophy" 
                title="No competitions found" 
                description="Start by adding your first competition"
            />
        @endif
    </x-admin.card>
</div>
@endsection
