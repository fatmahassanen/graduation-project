@props(['title', 'description' => null])

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $title }}</h1>
            @if($description)
                <p class="mt-1 text-sm text-gray-600">{{ $description }}</p>
            @endif
        </div>
        <div>
            {{ $slot }}
        </div>
    </div>
</div>
