@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <x-admin.page-header 
        title="Edit Tuition Fee" 
        description="Update tuition fee category information"
    />

    <x-admin.card>
        <form action="{{ route('admin.tuition-fees.update', $tuitionFee) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Year Range -->
            <div class="mb-6">
                <label for="year_range" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>Year Range *
                </label>
                <input 
                    type="text" 
                    name="year_range" 
                    id="year_range"
                    value="{{ old('year_range', $tuitionFee->year_range) }}"
                    required
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 p-3"
                    placeholder="e.g., Year 1 & Year 2"
                >
                @error('year_range')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount -->
            <div class="mb-6">
                <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>Annual Tuition (EGP) *
                </label>
                <input 
                    type="number" 
                    name="amount" 
                    id="amount"
                    value="{{ old('amount', $tuitionFee->amount) }}"
                    step="0.01"
                    min="0"
                    required
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200 p-3"
                    placeholder="e.g., 15000"
                >
                @error('amount')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Enter the annual tuition amount in Egyptian Pounds</p>
            </div>

            <!-- Order -->
            <div class="mb-6">
                <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-sort-numeric-down text-purple-600 mr-2"></i>Display Order
                </label>
                <input 
                    type="number" 
                    name="order" 
                    id="order"
                    value="{{ old('order', $tuitionFee->order) }}"
                    min="0"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 p-3"
                    placeholder="0"
                >
                @error('order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Lower numbers appear first</p>
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        id="is_active"
                        value="1"
                        {{ old('is_active', $tuitionFee->is_active) ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                    >
                    <span class="ml-3 text-sm font-medium text-gray-700">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>Active (Display on website)
                    </span>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.tuition-fees.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Update Tuition Fee
                </button>
            </div>
        </form>
    </x-admin.card>
</div>
@endsection
