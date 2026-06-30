@props(['type' => 'success', 'message' => null])

@php
    $classes = [
        'success' => 'bg-green-100 text-green-900 border-green-400',
        'error' => 'bg-red-100 text-red-900 border-red-400',
        'warning' => 'bg-yellow-100 text-yellow-900 border-yellow-400',
        'info' => 'bg-blue-100 text-blue-900 border-blue-400',
    ];
    
    $icons = [
        'success' => 'fa-check-circle',
        'error' => 'fa-exclamation-circle',
        'warning' => 'fa-exclamation-triangle',
        'info' => 'fa-info-circle',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'font-medium p-4 rounded border flex items-center mb-6 ' . $classes[$type]]) }}>
    <i class="fas {{ $icons[$type] }} mr-3"></i>
    <div class="flex-1">{{ $message ?? $slot }}</div>
    <button type="button" class="ml-4 hover:opacity-75" onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
    </button>
</div>
