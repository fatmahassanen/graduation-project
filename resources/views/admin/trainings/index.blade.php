@extends('layouts.admin')

@section('admin_content')
<div class="max-w-7xl mx-auto">
    <x-admin.page-header title="Trainings" description="Manage training programs">
        <a href="{{ route('admin.trainings.create') }}">
            <x-admin.button variant="success" icon="fa-plus">Add Training</x-admin.button>
        </a>
    </x-admin.page-header>

    @if(session('success'))
        <x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
    @endif

    <x-admin.card :padding="false">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Training</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($trainings as $training)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($training->image)
                                        <img src="{{ asset($training->image) }}" alt="{{ $training->title }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-chalkboard-teacher text-yellow-600"></i>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $training->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($training->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $training->instructor ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $training->start_date ? $training->start_date->format('M d, Y') : '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($training->is_active)
                                    <x-admin.badge variant="success">Active</x-admin.badge>
                                @else
                                    <x-admin.badge variant="default">Inactive</x-admin.badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.trainings.edit', $training) }}" class="text-blue-600 hover:text-blue-900 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.trainings.destroy', $training) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
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
                            <td colspan="5" class="px-6 py-12">
                                <x-admin.empty-state 
                                    icon="fa-chalkboard-teacher" 
                                    title="No trainings found" 
                                    description="Get started by creating your first training program"
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
