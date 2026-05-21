@props(['variant' => 'primary', 'size' => 'md', 'icon' => null])

@php
    $variants = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',
        'success' => 'bg-green-600 hover:bg-green-700 text-white',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
        'warning' => 'bg-yellow-500 hover:bg-yellow-600 text-white',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white',
        'outline' => 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300',
    ];
    
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 ' . $variants[$variant] . ' ' . $sizes[$size]]) }}>
    @if($icon)
        <i class="fas {{ $icon }} {{ $slot->isEmpty() ? '' : 'mr-2' }}"></i>
    @endif
    {{ $slot }}
</button>
