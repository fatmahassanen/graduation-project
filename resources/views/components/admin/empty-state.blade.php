@props(['icon' => 'fa-inbox', 'title', 'description' => null, 'action' => null])

<div class="text-center py-12">
    <i class="fas {{ $icon }} text-6xl text-gray-300 mb-4"></i>
    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $title }}</h3>
    @if($description)
        <p class="text-sm text-gray-500 mb-6">{{ $description }}</p>
    @endif
    @if($action)
        <div>{!! $action !!}</div>
    @endif
</div>
