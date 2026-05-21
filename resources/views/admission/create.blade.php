<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admission Application - {{ config('app.name', 'NCTU') }}</title>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .step-indicator {
            transition: all 0.3s ease;
        }
        .step-indicator.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .step-indicator.completed {
            background: #10b981;
            color: white;
        }
        .step-content {
            display: none;
        }
        .step-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .input-error {
            border-color: #ef4444 !important;
        }
    </style>
</head>
<body>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8" 
     x-data="admissionWizard({{ $admission ? $admission->current_step ?? 1 : 1 }})">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            @if(isset($isReapplication) && $isReapplication)
                <div class="mb-4 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg inline-block">
                    <div class="flex items-center">
                        <i class="fas fa-redo text-blue-600 text-2xl mr-3"></i>
                        <div class="text-left">
                            <p class="text-blue-800 font-bold">Re-application Mode</p>
                            <p class="text-sm text-blue-700">Your previous data has been auto-filled. Update what needs to be fixed and re-submit.</p>
                        </div>
                    </div>
                </div>
            @elseif(isset($isDraft) && $isDraft)
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg inline-block">
                    <div class="flex items-center">
                        <i class="fas fa-save text-green-600 text-2xl mr-3"></i>
                        <div class="text-left">
                            <p class="text-green-800 font-bold">Continue Your Application</p>
                            <p class="text-sm text-green-700">Your draft has been saved. Continue from where you left off.</p>
                        </div>
                    </div>
                </div>
            @endif
            <h2 class="text-4xl font-bold text-gray-900 mb-2">
                {{ isset($isReapplication) && $isReapplication ? 'Re-apply for Admission' : 'Admission Application' }}
            </h2>
            <p class="text-lg text-gray-600">Complete the form step by step</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-2xl mr-3"></i>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-3"></i>
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-3"></i>
                    <p class="text-red-700 font-bold">Please fix the following errors:</p>
                </div>
                <ul class="list-disc list-inside text-red-600 ml-8">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Step Indicators -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex items-center" @click="goToStep(1)" style="cursor: pointer;">
                    <div class="step-indicator w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg"
                         :class="{'active': currentStep === 1, 'completed': currentStep > 1, 'bg-gray-200 text-gray-600': currentStep < 1}">
                        <span x-show="currentStep <= 1">1</span>
                        <i class="fas fa-check" x-show="currentStep > 1"></i>
                    </div>
                    <div class="ml-3 hidden md:block">
                        <p class="text-sm font-semibold text-gray-700">Step 1</p>
                        <p class="text-xs text-gray-500">Personal Info</p>
                    </div>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2" :class="{'bg-green-500': currentStep > 1}"></div>
                
                <div class="flex-1 flex items-center" @click="goToStep(2)" style="cursor: pointer;">
                    <div class="step-indicator w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg"
                         :class="{'active': currentStep === 2, 'completed': currentStep > 2, 'bg-gray-200 text-gray-600': currentStep < 2}">
                        <span x-show="currentStep <= 2">2</span>
                        <i class="fas fa-check" x-show="currentStep > 2"></i>
                    </div>
                    <div class="ml-3 hidden md:block">
                        <p class="text-sm font-semibold text-gray-700">Step 2</p>
                        <p class="text-xs text-gray-500">Address & Contact</p>
                    </div>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2" :class="{'bg-green-500': currentStep > 2}"></div>
                
                <div class="flex-1 flex items-center" @click="goToStep(3)" style="cursor: pointer;">
                    <div class="step-indicator w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg"
                         :class="{'active': currentStep === 3, 'completed': currentStep > 3, 'bg-gray-200 text-gray-600': currentStep < 3}">
                        <span x-show="currentStep <= 3">3</span>
                        <i class="fas fa-check" x-show="currentStep > 3"></i>
                    </div>
                    <div class="ml-3 hidden md:block">
                        <p class="text-sm font-semibold text-gray-700">Step 3</p>
                        <p class="text-xs text-gray-500">Documents</p>
                    </div>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2" :class="{'bg-green-500': currentStep > 3}"></div>
                
                <div class="flex-1 flex items-center" @click="goToStep(4)" style="cursor: pointer;">
                    <div class="step-indicator w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg"
                         :class="{'active': currentStep === 4, 'completed': currentStep > 4, 'bg-gray-200 text-gray-600': currentStep < 4}">
                        <span x-show="currentStep <= 4">4</span>
                        <i class="fas fa-check" x-show="currentStep > 4"></i>
                    </div>
                    <div class="ml-3 hidden md:block">
                        <p class="text-sm font-semibold text-gray-700">Step 4</p>
                        <p class="text-xs text-gray-500">Parent Info</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Form -->
        <form method="POST" action="{{ route('admission.store') }}" enctype="multipart/form-data" 
              class="bg-white shadow-2xl rounded-2xl overflow-hidden" @submit="handleSubmit">
            @csrf
            <input type="hidden" name="current_step" x-model="currentStep">

            <!-- STEP 1: Personal Information & National ID -->
            <div class="step-content" :class="{'active': currentStep === 1}">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-user-circle mr-3"></i>
                        Step 1: Personal Information
                    </h3>
                </div>

                <div class="p-8 space-y-6">
                    <!-- National ID -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">National ID (14 digits) *</label>
                        <input type="text" id="national_id" name="national_id" 
                            value="{{ old('national_id', $admission->national_id ?? '') }}" 
                            maxlength="14"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-lg font-mono"
                            placeholder="30125011234567"
                            @blur="validateField('national_id')">
                        <div id="national_id_error" class="error-message hidden"></div>
                        <p class="text-sm text-gray-500 mt-1">
                            <i class="fas fa-info-circle"></i> Birth date, governorate, and gender will be auto-filled
                        </p>
                    </div>

                    <!-- Auto-extracted fields -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Birth Date *</label>
                            <input type="date" id="birth_date" name="birth_date" 
                                value="{{ old('birth_date', isset($admission) && $admission->birth_date ? $admission->birth_date->format('Y-m-d') : '') }}" 
                                max="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                @blur="validateField('birth_date')">
                            <div id="birth_date_error" class="error-message hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Birth Governorate *</label>
                            <input type="text" id="birth_governorate" name="birth_governorate" 
                                value="{{ old('birth_governorate', $admission->birth_governorate ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                @blur="validateField('birth_governorate')">
                            <div id="birth_governorate_error" class="error-message hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Gender *</label>
                            <div class="flex items-center space-x-6 mt-3">
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="male" 
                                        {{ old('gender', $admission->gender ?? '') === 'male' ? 'checked' : '' }} 
                                        class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-gray-700">Male</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="female" 
                                        {{ old('gender', $admission->gender ?? '') === 'female' ? 'checked' : '' }} 
                                        class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-gray-700">Female</span>
                                </label>
                            </div>
                            <div id="gender_error" class="error-message hidden"></div>
                        </div>
                    </div>

                    <!-- Full Name (Quadruple) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">First Name *</label>
                            <input type="text" name="first_name" id="first_name"
                                value="{{ old('first_name', $admission->first_name ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                @blur="validateField('first_name')">
                            <div id="first_name_error" class="error-message hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Second Name *</label>
                            <input type="text" name="second_name" id="second_name"
                                value="{{ old('second_name', $admission->second_name ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                @blur="validateField('second_name')">
                            <div id="second_name_error" class="error-message hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Third Name *</label>
                            <input type="text" name="third_name" id="third_name"
                                value="{{ old('third_name', $admission->third_name ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                @blur="validateField('third_name')">
                            <div id="third_name_error" class="error-message hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Fourth Name *</label>
                            <input type="text" name="fourth_name" id="fourth_name"
                                value="{{ old('fourth_name', $admission->fourth_name ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                @blur="validateField('fourth_name')">
                            <div id="fourth_name_error" class="error-message hidden"></div>
                        </div>
                    </div>

                    <!-- Religion & Phone -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Religion *</label>
                            <select name="religion" id="religion"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                @blur="validateField('religion')">
                                <option value="">Select Religion</option>
                                <option value="Muslim" {{ old('religion', $admission->religion ?? '') === 'Muslim' ? 'selected' : '' }}>Muslim</option>
                                <option value="Christian" {{ old('religion', $admission->religion ?? '') === 'Christian' ? 'selected' : '' }}>Christian</option>
                                <option value="Jewish" {{ old('religion', $admission->religion ?? '') === 'Jewish' ? 'selected' : '' }}>Jewish</option>
                                <option value="Other" {{ old('religion', $admission->religion ?? '') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <div id="religion_error" class="error-message hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" 
                                value="{{ old('phone', $admission->phone ?? '') }}" 
                                maxlength="11"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                placeholder="01012345678"
                                @blur="validateField('phone')">
                            <div id="phone_error" class="error-message hidden"></div>
                            <p class="text-xs text-gray-500 mt-1">11 digits starting with 010, 011, 012, or 015</p>
                        </div>
                    </div>

                    <!-- Email (Auto-filled, Read-only) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" 
                            value="{{ auth()->user()->email }}" 
                            readonly
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-lock"></i> Auto-filled from your account
                        </p>
                    </div>
                </div>
            </div>

            <!-- STEP 2: Address & Contact Information -->
            <div class="step-content" :class="{'active': currentStep === 2}">
                <div class="bg-gradient-to-r from-green-600 to-teal-600 px-8 py-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-map-marker-alt mr-3"></i>
                        Step 2: Address & Contact Information
                    </h3>
                </div>

                <div class="p-8 space-y-6">
                    <!-- Current Residence Governorate -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Current Residence Governorate *</label>
                        <select name="current_governorate" id="current_governorate"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                            @blur="validateField('current_governorate')">
                            <option value="">Select Current Governorate</option>
                            @foreach($governorates as $code => $name)
                                <option value="{{ $name }}" {{ old('current_governorate', $admission->current_governorate ?? '') === $name ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <div id="current_governorate_error" class="error-message hidden"></div>
                        <p class="text-xs text-gray-500 mt-1">Where you currently live</p>
                    </div>

                    <!-- City/Center & Village/District -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">City/Center *</label>
                            <input type="text" name="city_center" id="city_center"
                                value="{{ old('city_center', $admission->city_center ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                placeholder="e.g., Nasr City"
                                @blur="validateField('city_center')">
                            <div id="city_center_error" class="error-message hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Village/District *</label>
                            <input type="text" name="village_district" id="village_district"
                                value="{{ old('village_district', $admission->village_district ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                placeholder="e.g., District 3"
                                @blur="validateField('village_district')">
                            <div id="village_district_error" class="error-message hidden"></div>
                        </div>
                    </div>

                    <!-- Street Address -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Street Address *</label>
                        <textarea name="street_address" id="street_address" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                            placeholder="e.g., 15 Ahmed Zewail Street, Building 5, Apartment 10"
                            @blur="validateField('street_address')">{{ old('street_address', $admission->street_address ?? '') }}</textarea>
                        <div id="street_address_error" class="error-message hidden"></div>
                    </div>
                </div>
            </div>

            <!-- STEP 3: Documents -->
            <div class="step-content" :class="{'active': currentStep === 3}">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-file-upload mr-3"></i>
                        Step 3: Upload Documents
                    </h3>
                </div>

                <div class="p-8 space-y-6">
                    <!-- Student Photo -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Personal Photo {{ isset($isReapplication) && $isReapplication || isset($isDraft) && $isDraft ? '(Optional - keep existing or upload new)' : '*' }}
                        </label>
                        @if(isset($admission) && $admission->student_photo)
                            <div class="mb-2 p-3 bg-green-50 border border-green-200 rounded-lg flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                <span class="text-sm text-green-800">Current file: <strong>{{ basename($admission->student_photo) }}</strong></span>
                                <span class="ml-2 text-xs text-green-600">(Upload a new file to replace)</span>
                            </div>
                        @endif
                        <input type="file" name="student_photo" id="student_photo" accept="image/*" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            @change="handleFileChange('student_photo')">
                        <div id="student_photo_error" class="error-message hidden"></div>
                        <p class="text-sm text-gray-500 mt-1">Upload a clear photo (JPEG, PNG, max 2MB)</p>
                    </div>

                    <!-- Documents -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Birth Certificate (PDF) {{ isset($isReapplication) && $isReapplication || isset($isDraft) && $isDraft ? '(Optional)' : '*' }}
                            </label>
                            @if(isset($admission) && $admission->birth_certificate)
                                <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded text-xs">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                    <span class="text-green-800">Current: {{ basename($admission->birth_certificate) }}</span>
                                </div>
                            @endif
                            <input type="file" name="birth_certificate" id="birth_certificate" accept=".pdf" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                @change="handleFileChange('birth_certificate')">
                            <div id="birth_certificate_error" class="error-message hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Qualification Certificate (PDF) {{ isset($isReapplication) && $isReapplication || isset($isDraft) && $isDraft ? '(Optional)' : '*' }}
                            </label>
                            @if(isset($admission) && $admission->qualification_certificate)
                                <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded text-xs">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                    <span class="text-green-800">Current: {{ basename($admission->qualification_certificate) }}</span>
                                </div>
                            @endif
                            <input type="file" name="qualification_certificate" id="qualification_certificate" accept=".pdf" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                @change="handleFileChange('qualification_certificate')">
                            <div id="qualification_certificate_error" class="error-message hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Student ID (PDF) {{ isset($isReapplication) && $isReapplication || isset($isDraft) && $isDraft ? '(Optional)' : '*' }}
                            </label>
                            @if(isset($admission) && $admission->student_id_document)
                                <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded text-xs">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                    <span class="text-green-800">Current: {{ basename($admission->student_id_document) }}</span>
                                </div>
                            @endif
                            <input type="file" name="student_id_document" id="student_id_document" accept=".pdf" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                @change="handleFileChange('student_id_document')">
                            <div id="student_id_document_error" class="error-message hidden"></div>
                        </div>
                    </div>

                    <!-- File Uniqueness Warning -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mr-3 mt-1"></i>
                            <div>
                                <p class="text-sm font-semibold text-yellow-800">Important: Unique Files Required</p>
                                <p class="text-sm text-yellow-700 mt-1">You must upload different files for each requirement. Do not upload the same file multiple times.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 4: Parent/Guardian Information -->
            <div class="step-content" :class="{'active': currentStep === 4}">
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-users mr-3"></i>
                        Step 4: Parent/Guardian Information
                    </h3>
                </div>

                <div class="p-8 space-y-6">
                    <!-- Parent Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Parent/Guardian Name *</label>
                            <input type="text" name="parent_name" id="parent_name"
                                value="{{ old('parent_name', $admission->parent_name ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                @blur="validateField('parent_name')">
                            <div id="parent_name_error" class="error-message hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Parent Phone Number *</label>
                            <input type="tel" id="parent_phone" name="parent_phone" 
                                value="{{ old('parent_phone', $admission->parent_phone ?? '') }}" 
                                maxlength="11"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                placeholder="01198765432"
                                @blur="validateField('parent_phone')">
                            <div id="parent_phone_error" class="error-message hidden"></div>
                            <p class="text-xs text-gray-500 mt-1">11 digits starting with 010, 011, 012, or 015</p>
                        </div>
                    </div>

                    <!-- Father Occupation -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Father's Occupation *</label>
                        <input type="text" name="father_occupation" id="father_occupation"
                            value="{{ old('father_occupation', $admission->father_occupation ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            placeholder="e.g., Engineer, Teacher, Doctor"
                            @blur="validateField('father_occupation')">
                        <div id="father_occupation_error" class="error-message hidden"></div>
                    </div>

                    <!-- Parent ID -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Parent ID Document (PDF) {{ isset($isReapplication) && $isReapplication || isset($isDraft) && $isDraft ? '(Optional)' : '*' }}
                        </label>
                        @if(isset($admission) && $admission->parent_id_document)
                            <div class="mb-2 p-3 bg-green-50 border border-green-200 rounded-lg flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                <span class="text-sm text-green-800">Current file: <strong>{{ basename($admission->parent_id_document) }}</strong></span>
                                <span class="ml-2 text-xs text-green-600">(Upload a new file to replace)</span>
                            </div>
                        @endif
                        <input type="file" name="parent_id_document" id="parent_id_document" accept=".pdf" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            @change="handleFileChange('parent_id_document')">
                        <div id="parent_id_document_error" class="error-message hidden"></div>
                        <p class="text-sm text-gray-500 mt-1">Upload parent/guardian ID (max 5MB)</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="bg-gray-50 px-8 py-6">
                <div class="flex items-center justify-between">
                    <!-- Previous Button -->
                    <button type="button" @click="previousStep" x-show="currentStep > 1"
                        class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-semibold flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Previous
                    </button>
                    <div x-show="currentStep === 1"></div>

                    <div class="flex items-center space-x-4">
                        <!-- Save as Draft Button -->
                        <button type="submit" name="save_draft" value="1"
                            class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition font-semibold flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Save as Draft
                        </button>

                        <!-- Next Button -->
                        <button type="button" @click="nextStep" x-show="currentStep < 4"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition font-semibold flex items-center">
                            Next
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>

                        <!-- Submit Button -->
                        <button type="submit" x-show="currentStep === 4"
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600 text-white rounded-lg hover:from-green-700 hover:to-teal-700 transition font-semibold flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            {{ isset($isReapplication) && $isReapplication ? 'Re-submit Application' : 'Submit Application' }}
                        </button>
                    </div>
                </div>
                <p class="text-center text-sm text-gray-600 mt-4">
                    All fields marked with * are required for final submission
                </p>
            </div>
        </form>
    </div>
</div>

<!-- Include National ID Extractor JavaScript -->
<script src="{{ asset('js/national-id-extractor.js') }}"></script>

<script>
function admissionWizard(initialStep = 1) {
    return {
        currentStep: initialStep,
        uploadedFiles: {},
        
        init() {
            // Restore file names if validation failed
            this.restoreFileNames();
        },
        
        goToStep(step) {
            // Allow clicking on completed steps
            if (step <= this.currentStep || step === this.currentStep + 1) {
                this.currentStep = step;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        
        nextStep() {
            if (this.validateCurrentStep()) {
                this.currentStep++;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        
        previousStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        
        validateCurrentStep() {
            let isValid = true;
            const requiredFields = this.getRequiredFieldsForStep(this.currentStep);
            
            requiredFields.forEach(fieldId => {
                if (!this.validateField(fieldId)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                alert('Please fill in all required fields before proceeding to the next step.');
            }
            
            return isValid;
        },
        
        getRequiredFieldsForStep(step) {
            const fieldsByStep = {
                1: ['national_id', 'birth_date', 'birth_governorate', 'gender', 'first_name', 'second_name', 'third_name', 'fourth_name', 'religion', 'phone'],
                2: ['current_governorate', 'city_center', 'village_district', 'street_address'],
                3: [], // Files are optional for draft, required for final submission
                4: ['parent_name', 'parent_phone', 'father_occupation']
            };
            return fieldsByStep[step] || [];
        },
        
        validateField(fieldId) {
            const field = document.getElementById(fieldId);
            const errorDiv = document.getElementById(fieldId + '_error');
            
            if (!field) return true;
            
            let isValid = true;
            let errorMessage = '';
            
            // Check if field is empty
            if (field.type === 'radio') {
                const radioGroup = document.getElementsByName(field.name);
                const isChecked = Array.from(radioGroup).some(radio => radio.checked);
                if (!isChecked) {
                    isValid = false;
                    errorMessage = 'This field is required.';
                }
            } else if (!field.value || field.value.trim() === '') {
                isValid = false;
                errorMessage = 'This field is required.';
            } else {
                // Field-specific validation
                switch(fieldId) {
                    case 'national_id':
                        if (!/^\d{14}$/.test(field.value)) {
                            isValid = false;
                            errorMessage = 'National ID must be exactly 14 digits.';
                        }
                        break;
                    case 'phone':
                    case 'parent_phone':
                        if (!/^(010|011|012|015)\d{8}$/.test(field.value)) {
                            isValid = false;
                            errorMessage = 'Phone must be 11 digits starting with 010, 011, 012, or 015.';
                        }
                        break;
                    case 'birth_date':
                        const birthDate = new Date(field.value);
                        const today = new Date();
                        if (birthDate >= today) {
                            isValid = false;
                            errorMessage = 'Birth date must be in the past.';
                        }
                        break;
                }
            }
            
            // Show/hide error message
            if (errorDiv) {
                if (!isValid) {
                    errorDiv.textContent = errorMessage;
                    errorDiv.classList.remove('hidden');
                    field.classList.add('input-error');
                } else {
                    errorDiv.classList.add('hidden');
                    field.classList.remove('input-error');
                }
            }
            
            return isValid;
        },
        
        handleFileChange(fieldId) {
            const fileInput = document.getElementById(fieldId);
            if (fileInput && fileInput.files.length > 0) {
                this.uploadedFiles[fieldId] = fileInput.files[0].name;
                // Store in sessionStorage to persist across page reloads
                sessionStorage.setItem('uploaded_' + fieldId, fileInput.files[0].name);
            }
        },
        
        restoreFileNames() {
            // Restore file names from sessionStorage after validation failure
            const fileFields = ['student_photo', 'birth_certificate', 'qualification_certificate', 'student_id_document', 'parent_id_document'];
            fileFields.forEach(fieldId => {
                const storedName = sessionStorage.getItem('uploaded_' + fieldId);
                if (storedName) {
                    this.uploadedFiles[fieldId] = storedName;
                }
            });
        },
        
        handleSubmit(event) {
            // Don't validate if saving as draft
            if (event.submitter && event.submitter.name === 'save_draft') {
                return true;
            }
            
            // Validate all steps before final submission
            let allValid = true;
            for (let step = 1; step <= 4; step++) {
                const requiredFields = this.getRequiredFieldsForStep(step);
                requiredFields.forEach(fieldId => {
                    if (!this.validateField(fieldId)) {
                        allValid = false;
                    }
                });
            }
            
            if (!allValid) {
                event.preventDefault();
                alert('Please complete all required fields in all steps before submitting.');
                return false;
            }
            
            // Clear sessionStorage on successful submission
            sessionStorage.clear();
            return true;
        }
    }
}
</script>
</body>
</html>
