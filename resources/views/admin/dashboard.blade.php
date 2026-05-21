@extends('layouts.admin')

@section('admin_content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header with View Website Button -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            {{-- <p class="mt-1 text-sm text-gray-600">Welcome back! Here's what's happening with your content.</p> --}}
        </div>
        <!-- <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200">
            <i class="fas fa-external-link-alt mr-2"></i>
            View Website
        </a> -->
    </div>

    <!-- Admission Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Pending Applications Card -->
        <a href="{{ route('admin.admissions.pending') }}" class="block bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200 hover:shadow-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-50 text-sm font-medium uppercase tracking-wide">Pending Applications</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['pending_admissions'] }}</p>
                    <p class="text-yellow-100 text-xs mt-2">Click to review</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-clock text-3xl"></i>
                </div>
            </div>
        </a>

        <!-- Accepted Students Card -->
        <a href="{{ route('admin.admissions.accepted') }}" class="block bg-gradient-to-br from-green-400 to-emerald-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200 hover:shadow-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-50 text-sm font-medium uppercase tracking-wide">Accepted Students</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['accepted_admissions'] }}</p>
                    <p class="text-green-100 text-xs mt-2">View accepted list</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
            </div>
        </a>

        <!-- Rejected Students Card -->
        <a href="{{ route('admin.admissions.rejected') }}" class="block bg-gradient-to-br from-red-400 to-pink-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200 hover:shadow-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-50 text-sm font-medium uppercase tracking-wide">Rejected Applications</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['rejected_admissions'] }}</p>
                    <p class="text-red-100 text-xs mt-2">View rejected list</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-times-circle text-3xl"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Events Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Events</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['events'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- News Card -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium uppercase tracking-wide">News</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['news'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-newspaper text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Departments Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium uppercase tracking-wide">Departments</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['departments'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-building text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Gallery Card -->
        <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-pink-100 text-sm font-medium uppercase tracking-wide">Gallery</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['gallery'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-images text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Trainings Card -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium uppercase tracking-wide">Trainings</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['trainings'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-chalkboard-teacher text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Activities Card -->
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium uppercase tracking-wide">Activities</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['activities'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-trophy text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <x-admin.card title="Quick Actions" class="mb-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <a href="{{ route('admin.events.create') }}" class="flex flex-col items-center justify-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                <i class="fas fa-plus-circle text-3xl text-blue-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-gray-700">Add Event</span>
            </a>
            <a href="{{ route('admin.news.create') }}" class="flex flex-col items-center justify-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                <i class="fas fa-plus-circle text-3xl text-purple-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-gray-700">Add News</span>
            </a>
            <a href="{{ route('admin.gallery.create') }}" class="flex flex-col items-center justify-center p-4 bg-pink-50 hover:bg-pink-100 rounded-lg transition-colors group">
                <i class="fas fa-plus-circle text-3xl text-pink-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-gray-700">Add Gallery</span>
            </a>
            <a href="{{ route('admin.trainings.create') }}" class="flex flex-col items-center justify-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors group">
                <i class="fas fa-plus-circle text-3xl text-yellow-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-gray-700">Add Training</span>
            </a>
            <a href="{{ route('admin.activities.create') }}" class="flex flex-col items-center justify-center p-4 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors group">
                <i class="fas fa-plus-circle text-3xl text-indigo-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-gray-700">Add Activity</span>
            </a>
        </div>
    </x-admin.card>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Events -->
        <x-admin.card title="Recent Events">
            @if($recentEvents->count() > 0)
                <div class="space-y-3">
                    @foreach($recentEvents as $event)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-3 flex-1 min-w-0">
                                @if($event->image)
                                    <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                @else
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-calendar-alt text-blue-600"></i>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $event->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $event->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.events.edit', $event) }}" class="ml-3 text-blue-600 hover:text-blue-800 flex-shrink-0">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.events.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                        View all events <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @else
                <x-admin.empty-state
                    icon="fa-calendar-alt"
                    title="No events yet"
                    description="Start by creating your first event"
                />
            @endif
        </x-admin.card>

        <!-- Recent News -->
        <x-admin.card title="Recent News">
            @if($recentNews->count() > 0)
                <div class="space-y-3">
                    @foreach($recentNews as $news)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-3 flex-1 min-w-0">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-newspaper text-purple-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $news->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $news->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.news.edit', $news) }}" class="ml-3 text-purple-600 hover:text-purple-800 flex-shrink-0">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.news.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-800">
                        View all news <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @else
                <x-admin.empty-state
                    icon="fa-newspaper"
                    title="No news yet"
                    description="Start by creating your first news article"
                />
            @endif
        </x-admin.card>
    </div>
</div>
@endsection
