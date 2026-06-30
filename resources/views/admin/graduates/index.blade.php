@extends('layouts.admin')

@section('admin_content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Graduates</h1>
            <p class="mt-1 text-sm text-gray-600">Manage graduate achievement cards</p>
        </div>
        <a href="{{ route('admin.graduates.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-semibold rounded-lg shadow-lg hover:from-teal-700 hover:to-teal-800 transform hover:scale-105 transition-all duration-200">
            <i class="fas fa-plus mr-2"></i>
            Add New Graduate
        </a>
    </div>

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" class="mb-6" />
    @endif

    <!-- Graduates List -->
    <x-admin.card>
        @if($graduates->count() > 0)
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
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($graduates as $graduate)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-teal-100 text-teal-800">
                                        {{ $graduate->order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($graduate->image)
                                        <img src="{{ asset($graduate->image) }}" alt="{{ $graduate->title }}" class="w-16 h-16 rounded object-cover border border-gray-200">
                                    @else
                                        <div class="w-16 h-16 rounded bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($graduate->title, 50) }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($graduate->description, 60) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($graduate->is_active)
                                        <x-admin.badge type="success">Active</x-admin.badge>
                                    @else
                                        <x-admin.badge type="secondary">Inactive</x-admin.badge>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.graduates.edit', $graduate) }}" class="inline-flex items-center px-3 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.graduates.destroy', $graduate) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this graduate achievement?');">
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
                icon="fa-graduation-cap" 
                title="No graduate achievements found" 
                description="Start by adding your first graduate achievement"
            />
        @endif
    </x-admin.card>
</div>
@endsection
