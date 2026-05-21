@extends('layouts.admin')

@section('admin_content')
<div class="max-w-7xl mx-auto">
    <x-admin.page-header 
        title="Testimonials" 
        description="Manage graduate success stories and testimonials"
    />

    @if(session('success'))
        <x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
    @endif

    <x-admin.card :padding="false">
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Drag to Reorder</h3>
                    <p class="text-sm text-gray-600 mt-1">Drag and drop testimonials to change their display order on the homepage</p>
                </div>
                <button id="saveOrderBtn" class="hidden px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Save Order
                </button>
            </div>
        </div>

        <div id="testimonials-list" class="divide-y divide-gray-200">
            @forelse($testimonials as $testimonial)
                <div class="testimonial-item p-6 hover:bg-gray-50 transition-colors cursor-move" data-id="{{ $testimonial->id }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4 flex-1">
                            <div class="flex-shrink-0">
                                <i class="fas fa-grip-vertical text-gray-400 text-xl"></i>
                            </div>
                            @if($testimonial->photo)
                                <img src="{{ asset($testimonial->photo) }}" alt="{{ $testimonial->student_name }}" class="w-16 h-16 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user-graduate text-orange-600 text-2xl"></i>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-3">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $testimonial->student_name }}</h4>
                                    @if($testimonial->is_active)
                                        <x-admin.badge variant="success">Active</x-admin.badge>
                                    @else
                                        <x-admin.badge variant="default">Inactive</x-admin.badge>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $testimonial->department }}</p>
                                <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $testimonial->testimonial }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 ml-4">
                            <span class="text-sm font-medium text-gray-500">Order: <span class="order-number">{{ $testimonial->order }}</span></span>
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-edit mr-2"></i>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12">
                    <x-admin.empty-state 
                        icon="fa-user-graduate" 
                        title="No testimonials found" 
                        description="Testimonials will appear here once they are added to the system"
                    />
                </div>
            @endforelse
        </div>
    </x-admin.card>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const testimonialsList = document.getElementById('testimonials-list');
    const saveOrderBtn = document.getElementById('saveOrderBtn');
    let orderChanged = false;

    if (testimonialsList) {
        const sortable = new Sortable(testimonialsList, {
            animation: 150,
            handle: '.testimonial-item',
            ghostClass: 'bg-blue-50',
            onEnd: function() {
                orderChanged = true;
                saveOrderBtn.classList.remove('hidden');
                updateOrderNumbers();
            }
        });
    }

    function updateOrderNumbers() {
        const items = testimonialsList.querySelectorAll('.testimonial-item');
        items.forEach((item, index) => {
            item.querySelector('.order-number').textContent = index + 1;
        });
    }

    saveOrderBtn.addEventListener('click', function() {
        const items = testimonialsList.querySelectorAll('.testimonial-item');
        const testimonials = [];
        
        items.forEach((item, index) => {
            testimonials.push({
                id: item.dataset.id,
                order: index + 1
            });
        });

        saveOrderBtn.disabled = true;
        saveOrderBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';

        fetch('{{ route('admin.testimonials.update-order') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ testimonials: testimonials })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                saveOrderBtn.classList.add('hidden');
                saveOrderBtn.disabled = false;
                saveOrderBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Save Order';
                orderChanged = false;
                
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                alert.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Order saved successfully!';
                document.body.appendChild(alert);
                setTimeout(() => alert.remove(), 3000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            saveOrderBtn.disabled = false;
            saveOrderBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Save Order';
        });
    });
});
</script>
@endpush
@endsection
