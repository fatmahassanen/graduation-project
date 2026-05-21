@extends('layouts.admin')

@section('admin_content')
<div class="max-w-7xl mx-auto">
    <x-admin.page-header title="News" description="Manage news articles and announcements">
        <a href="{{ route('admin.news.create') }}">
            <x-admin.button variant="success" icon="fa-plus">Add News</x-admin.button>
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($news as $article)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-newspaper text-purple-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $article->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($article->excerpt ?? $article->content, 60) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $article->published_at ? $article->published_at->format('M d, Y') : '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($article->is_active)
                                    <x-admin.badge variant="success">Active</x-admin.badge>
                                @else
                                    <x-admin.badge variant="default">Inactive</x-admin.badge>
                                @endif
                                @if($article->is_featured)
                                    <x-admin.badge variant="warning">Featured</x-admin.badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.news.edit', $article) }}" class="text-blue-600 hover:text-blue-900 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
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
                                    icon="fa-newspaper" 
                                    title="No news found" 
                                    description="Get started by creating your first news article"
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
