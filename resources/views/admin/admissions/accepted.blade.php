@extends('layouts.admin')

@section('admin_content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Accepted Students</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    @if($admissions->isEmpty())
    <div class="bg-white rounded-lg shadow-lg p-12 text-center">
        <i class="fas fa-check-circle text-gray-300 text-6xl mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">No Accepted Students Yet</h3>
        <p class="text-gray-500">Accepted applications will appear here</p>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-green-500 to-emerald-600">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Student Code</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Student Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">National ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Applied Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Accepted Date</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($admissions as $admission)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-mono font-bold text-sm">
                                {{ $admission->student_code }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($admission->student_photo)
                                <img src="{{ $admission->fileUrl($admission->student_photo) }}" alt="Photo" class="w-10 h-10 rounded-full object-cover mr-3">
                                @else
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-green-600"></i>
                                </div>
                                @endif
                                <span class="font-medium text-gray-900">{{ $admission->full_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">
                            {{ $admission->national_id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $admission->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $admission->phone }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $admission->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $admission->reviewed_at ? $admission->reviewed_at->format('M d, Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a href="{{ route('admin.admissions.show', $admission) }}" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                <i class="fas fa-eye mr-2"></i>View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between text-sm text-gray-600">
            <span>Total Accepted Students: <strong class="text-green-600">{{ $admissions->count() }}</strong></span>
        </div>
    </div>
    @endif
</div>
@endsection
