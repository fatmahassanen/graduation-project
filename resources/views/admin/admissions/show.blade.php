@extends('layouts.admin')

@section('admin_content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Review Application</h1>
        <a href="{{ route('admin.admissions.pending') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to Pending
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Student Information -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-user-graduate mr-3"></i>
                        Student Information
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Full Name</label>
                            <p class="text-lg font-medium text-gray-900">{{ $admission->full_name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-600">National ID</label>
                            <p class="text-lg font-mono text-gray-900">{{ $admission->national_id }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Email</label>
                            <p class="text-lg text-gray-900">{{ $admission->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Phone</label>
                            <p class="text-lg text-gray-900">{{ $admission->phone }}</p>
                        </div>
                        @if($admission->gender)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Gender</label>
                            <p class="text-lg text-gray-900">{{ ucfirst($admission->gender) }}</p>
                        </div>
                        @endif
                        @if($admission->religion)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Religion (???????)</label>
                            <p class="text-lg text-gray-900">{{ $admission->religion }}</p>
                        </div>
                        @endif
                        @if($admission->birth_date)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Birth Date (????? ???????)</label>
                            <p class="text-lg text-gray-900">{{ $admission->birth_date->format('M d, Y') }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Applied Date</label>
                            <p class="text-lg text-gray-900">{{ $admission->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    @if($admission->student_photo)
                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-2">Student Photo</label>
                        <img src="{{ asset('img/' . $admission->student_photo) }}" alt="Student Photo" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200">
                    </div>
                    @endif

                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-2">Documents</label>
                        <div class="grid grid-cols-3 gap-3">
                            @if($admission->birth_certificate)
                            <a href="{{ asset('img/' . $admission->birth_certificate) }}" target="_blank" 
                                class="flex items-center justify-center px-4 py-3 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition">
                                <i class="fas fa-file-pdf mr-2"></i>
                                Birth Cert
                            </a>
                            @endif
                            @if($admission->qualification_certificate)
                            <a href="{{ asset('img/' . $admission->qualification_certificate) }}" target="_blank" 
                                class="flex items-center justify-center px-4 py-3 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition">
                                <i class="fas fa-file-pdf mr-2"></i>
                                Qualification
                            </a>
                            @endif
                            @if($admission->student_id_document)
                            <a href="{{ asset('img/' . $admission->student_id_document) }}" target="_blank" 
                                class="flex items-center justify-center px-4 py-3 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition">
                                <i class="fas fa-file-pdf mr-2"></i>
                                Student ID
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-map-marker-alt mr-3"></i>
                        Address Information
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        @if($admission->birth_governorate)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Birth Governorate</label>
                            <p class="text-lg text-gray-900">{{ $admission->birth_governorate }}</p>
                        </div>
                        @endif
                        @if($admission->current_governorate)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Current Governorate</label>
                            <p class="text-lg text-gray-900">{{ $admission->current_governorate }}</p>
                        </div>
                        @endif
                        @if($admission->city_center)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">City/Center</label>
                            <p class="text-lg text-gray-900">{{ $admission->city_center }}</p>
                        </div>
                        @endif
                        @if($admission->village_district)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Village/District</label>
                            <p class="text-lg text-gray-900">{{ $admission->village_district }}</p>
                        </div>
                        @endif
                    </div>
                    @if($admission->street_address)
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Street Address</label>
                        <p class="text-lg text-gray-900">{{ $admission->street_address }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Parent Information -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-users mr-3"></i>
                        Parent/Guardian Information
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Parent Name</label>
                            <p class="text-lg font-medium text-gray-900">{{ $admission->parent_name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Parent Phone</label>
                            <p class="text-lg text-gray-900">{{ $admission->parent_phone }}</p>
                        </div>
                        @if($admission->father_occupation)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Father's Occupation (????? ????)</label>
                            <p class="text-lg text-gray-900">{{ $admission->father_occupation }}</p>
                        </div>
                        @endif
                    </div>

                    @if($admission->parent_id_document)
                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-2">Parent ID Document</label>
                        <a href="{{ asset('img/' . $admission->parent_id_document) }}" target="_blank" 
                            class="inline-flex items-center px-4 py-3 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition">
                            <i class="fas fa-file-pdf mr-2"></i>
                            View Parent ID
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Application Status</h3>
                <div class="flex items-center justify-center py-4">
                    @if($admission->status === 'pending')
                        <span class="px-6 py-3 bg-yellow-100 text-yellow-800 rounded-full font-bold text-lg">
                            <i class="fas fa-clock mr-2"></i>
                            Pending
                        </span>
                    @elseif($admission->status === 'accepted')
                        <span class="px-6 py-3 bg-green-100 text-green-800 rounded-full font-bold text-lg">
                            <i class="fas fa-check-circle mr-2"></i>
                            Accepted
                        </span>
                    @elseif($admission->status === 'rejected')
                        <span class="px-6 py-3 bg-red-100 text-red-800 rounded-full font-bold text-lg">
                            <i class="fas fa-times-circle mr-2"></i>
                            Rejected
                        </span>
                    @endif
                </div>

                @if($admission->status === 'accepted' && $admission->student_code)
                <div class="mt-4 p-3 bg-blue-50 rounded-lg text-center">
                    <p class="text-sm text-gray-600 mb-1">Student Code</p>
                    <p class="text-lg font-bold text-blue-600 font-mono">{{ $admission->student_code }}</p>
                </div>
                @endif

                @if($admission->status === 'rejected' && $admission->rejection_reason)
                <div class="mt-4 p-3 bg-red-50 rounded-lg">
                    <p class="text-sm font-semibold text-red-800 mb-1">Rejection Reason:</p>
                    <p class="text-sm text-red-700">{{ $admission->rejection_reason }}</p>
                </div>
                @endif
            </div>

            <!-- Action Buttons (Only for Pending Status) -->
            @if($admission->status === 'pending')
            <!-- Approve Button -->
            <button onclick="showApproveModal()" 
                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold py-4 px-6 rounded-lg hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition shadow-lg flex items-center justify-center">
                <i class="fas fa-check-circle mr-2 text-xl"></i>
                Approve Application
            </button>

            <!-- Reject Button -->
            <button onclick="showRejectModal()" 
                class="w-full bg-gradient-to-r from-red-500 to-pink-600 text-white font-bold py-4 px-6 rounded-lg hover:from-red-600 hover:to-pink-700 transform hover:scale-105 transition shadow-lg flex items-center justify-center">
                <i class="fas fa-times-circle mr-2 text-xl"></i>
                Reject Application
            </button>
            @else
            <!-- Already Reviewed Message -->
            <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-6 text-center">
                <i class="fas fa-info-circle text-gray-400 text-3xl mb-3"></i>
                <p class="text-gray-600 font-medium">This application has already been reviewed.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all">
        <div class="text-center mb-6">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                <i class="fas fa-check-circle text-green-600 text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Approve Application</h3>
            <p class="text-gray-600">Enter a unique student code for this student</p>
        </div>

        <form method="POST" action="{{ route('admin.admissions.approve', $admission) }}">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Student Code *</label>
                <input type="text" name="student_code" id="student_code_input" required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-lg font-mono"
                    placeholder="e.g., 20260001">
                <p class="text-sm text-gray-500 mt-2">This code will be sent to the student via email</p>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="hideApproveModal()" 
                    class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" 
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-lg hover:from-green-600 hover:to-emerald-700 transition">
                    Approve & Send Email
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all">
        <div class="text-center mb-6">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                <i class="fas fa-times-circle text-red-600 text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Reject Application</h3>
            <p class="text-gray-600">Are you sure you want to reject this application?</p>
        </div>

        <form method="POST" action="{{ route('admin.admissions.reject', $admission) }}">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Rejection Reason (Optional)</label>
                <textarea name="rejection_reason" rows="4"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                    placeholder="Enter reason for rejection..."></textarea>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="hideRejectModal()" 
                    class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" 
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white font-semibold rounded-lg hover:from-red-600 hover:to-pink-700 transition">
                    Confirm Rejection
                </button>
            </div>
        </form>
    </div>
</div>

<script>
async function showApproveModal() {
    const modal = document.getElementById('approveModal');
    const codeInput = document.getElementById('student_code_input');
    const admissionId = {{ $admission->id }};
    
    // Show modal immediately
    modal.classList.remove('hidden');
    
    // Show loading state
    codeInput.value = 'Loading...';
    codeInput.disabled = true;
    
    try {
        // Make AJAX request to generate code
        const response = await fetch(`/api/admissions/${admissionId}/generate-code`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Populate input with generated code and enable it
            codeInput.value = data.code;
            codeInput.disabled = false;
        } else {
            // Clear input, enable it, and show error
            codeInput.value = '';
            codeInput.disabled = false;
            alert('Failed to generate code: ' + data.message);
        }
    } catch (error) {
        // Clear input, enable it, and show error
        codeInput.value = '';
        codeInput.disabled = false;
        alert('Error generating code. Please enter manually.');
        console.error('Code generation error:', error);
    }
}

function hideApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
}

function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection
