@extends('layouts.admin')

@section('admin_content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <x-admin.page-header title="Events" description="Manage university events and conferences">
        <a href="{{ route('admin.events.create') }}">
            <x-admin.button variant="success" icon="fa-plus">
                Add Event
            </x-admin.button>
        </a>
    </x-admin.page-header>

    <!-- Success Message -->
    @if(session('success'))
        <x-admin.alert type="success">
            {{ session('success') }}
        </x-admin.alert>
    @endif

    <!-- Events Table -->
    <x-admin.card :padding="false">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($events as $event)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($event->image)
                                        <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-calendar-alt text-blue-600"></i>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($event->description, 60) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($event->link)
                                    <a href="{{ $event->link }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm">
                                        <i class="fas fa-external-link-alt mr-1"></i> View
                                    </a>
                                @else
                                    <span class="text-sm text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.events.edit', $event) }}" class="text-blue-600 hover:text-blue-900 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
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
                            <td colspan="3" class="px-6 py-12">
                                <x-admin.empty-state 
                                    icon="fa-calendar-alt" 
                                    title="No events found" 
                                    description="Get started by creating your first event"
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
