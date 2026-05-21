@extends('layouts.admin')

@section('admin_content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <x-admin.page-header title="Activities" description="Manage student activities and achievements">
        <a href="{{ route('admin.activities.create') }}">
            <x-admin.button variant="success" icon="fa-plus">
                Add Activity
            </x-admin.button>
        </a>
    </x-admin.page-header>

    <!-- Success Message -->
    @if(session('success'))
        <x-admin.alert type="success">
            {{ session('success') }}
        </x-admin.alert>
    @endif

    <!-- Activities Table -->
    <x-admin.card :padding="false">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activities as $activity)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($activity->image)
                                        <img src="{{ $activity->image_url }}" alt="{{ $activity->title }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-trophy text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $activity->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($activity->description, 60) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($activity->category)
                                    <x-admin.badge variant="info">{{ $activity->category }}</x-admin.badge>
                                @else
                                    <span class="text-sm text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($activity->is_active)
                                    <x-admin.badge variant="success">Active</x-admin.badge>
                                @else
                                    <x-admin.badge variant="default">Inactive</x-admin.badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.activities.edit', $activity) }}" class="text-blue-600 hover:text-blue-900 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this activity?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12">
                                <x-admin.empty-state 
                                    icon="fa-trophy" 
                                    title="No activities found" 
                                    description="Get started by creating your first activity"
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-admin.card>
</div>
@endsection
