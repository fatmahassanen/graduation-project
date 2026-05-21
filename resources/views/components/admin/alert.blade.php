@props(['type' => 'success'])

@php
    $classes = [
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    ];
    
    $icons = [
        'success' => 'fa-check-circle',
        'error' => 'fa-exclamation-circle',
        'warning' => 'fa-exclamation-triangle',
        'info' => 'fa-info-circle',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-lg border p-4 mb-6 flex items-center ' . $classes[$type]]) }}>
    <i class="fas {{ $icons[$type] }} mr-3"></i>
    <div class="flex-1">{{ $slot }}</div>
    <button type="button" class="ml-4 text-gray-500 hover:text-gray-700" onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
    </button>
</div>
