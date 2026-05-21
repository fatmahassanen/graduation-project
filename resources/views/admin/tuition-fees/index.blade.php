@extends('layouts.admin')

@section('admin_content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tuition Fees Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage academic year and tuition fee categories</p>
        </div>
    </div>

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" class="mb-6" />
    @endif

    <!-- Academic Year Settings -->
    <x-admin.card class="mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>Academic Year Settings
        </h2>
        <form action="{{ route('admin.tuition-fees.update-settings') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="academic_year" class="block text-sm font-semibold text-gray-700 mb-2">Academic Year</label>
                    <input 
                        type="text" 
                        name="academic_year" 
                        id="academic_year"
                        value="{{ $academicYear }}"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 p-3"
                        placeholder="e.g., 2025–2026"
                        required
                    >
                    <p class="text-sm text-gray-500 mt-1">Enter the academic year (e.g., 2025–2026)</p>
                </div>
                <div>
                    <label for="announcement" class="block text-sm font-semibold text-gray-700 mb-2">Announcement (Optional)</label>
                    <textarea 
                        name="announcement" 
                        id="announcement"
                        rows="3"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 p-3"
                        placeholder="e.g., As announced in August 2025, there will be no increase in tuition fees for the upcoming year."
                    >{{ $announcement }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Optional announcement text to display on the fees page</p>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Update Settings
                    </button>
                </div>
            </div>
        </form>
    </x-admin.card>

    <!-- Tuition Fees List -->
    <x-admin.card>
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>Tuition Fee Categories
        </h2>
        @if($fees->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Year Range
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount (EGP)
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
                        @foreach($fees as $fee)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                        {{ $fee->order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $fee->year_range }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600">{{ number_format($fee->amount, 0) }} EGP</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($fee->is_active)
                                        <x-admin.badge type="success">Active</x-admin.badge>
                                    @else
                                        <x-admin.badge type="secondary">Inactive</x-admin.badge>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.tuition-fees.edit', $fee) }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-admin.empty-state 
                icon="fa-money-bill-wave" 
                title="No tuition fees found" 
                description="Run the seeder to populate initial data"
            />
        @endif
    </x-admin.card>
</div>
@endsection
