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
        /* Minimal Step Indicator Styles */
        .step-indicator {
            transition: all 0.3s ease;
        }
        .step-indicator.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }
        .step-indicator.completed {
            background: #198754;
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
            color: #dc3545;
            font-size: 0.813rem;
            margin-top: 0.375rem;
            font-weight: 500;
        }
        .input-error {
            border-color: #dc3545 !important;
            background-color: #fff5f5 !important;
        }
        
        /* Minimal Form Input Styles */
        .form-input {
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.938rem;
            color: #212529;
            transition: all 0.2s ease;
            background: #ffffff;
        }
        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .form-input::placeholder {
            color: #adb5bd;
        }
        
        /* Minimal Label Styles */
        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        /* Minimal Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.938rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }
        .btn-secondary {
            background: #f8f9fa;
            color: #495057;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.938rem;
            border: 1px solid #e9ecef;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: #e9ecef;
        }
    </style>
</head>
<body style="background: #f8f9fa; min-height: 100vh; padding: 3rem 0;">
<div class="container" style="max-width: 1100px; margin: 0 auto; padding: 0 1.5rem;"
     x-data="admissionWizard({{ $admission ? $admission->current_step ?? 1 : 1 }})">
    
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 2.5rem;">
            @if(isset($isReapplication) && $isReapplication)
                <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #cfe2ff; border-left: 4px solid #0d6efd !important; display: inline-block; padding: 1rem 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-redo" style="color: #084298; font-size: 1.5rem;"></i>
                        <div style="text-align: left;">
                            <p style="color: #084298; font-weight: 600; margin: 0; font-size: 0.938rem;">Re-application Mode</p>
                            <p style="color: #084298; font-size: 0.813rem; margin: 0;">Your previous data has been auto-filled. Update what needs to be fixed.</p>
                        </div>
                    </div>
                </div>
            @elseif(isset($isDraft) && $isDraft)
                <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #d1e7dd; border-left: 4px solid #198754 !important; display: inline-block; padding: 1rem 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-save" style="color: #0a3622; font-size: 1.5rem;"></i>
                        <div style="text-align: left;">
                            <p style="color: #0a3622; font-weight: 600; margin: 0; font-size: 0.938rem;">Continue Your Application</p>
                            <p style="color: #0a3622; font-size: 0.813rem; margin: 0;">Your draft has been saved. Continue from where you left off.</p>
                        </div>
                    </div>
                </div>
            @endif
            <h2 style="font-size: 2rem; font-weight: 700; color: #212529; margin-bottom: 0.5rem;">
                {{ isset($isReapplication) && $isReapplication ? 'Re-apply for Admission' : 'Admission Application' }}
            </h2>
            <p style="font-size: 1rem; color: #6c757d;">Complete the form step by step</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #d1e7dd; border-left: 4px solid #198754 !important; padding: 1rem 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-check-circle" style="color: #0a3622; font-size: 1.5rem;"></i>
                    <p style="color: #0a3622; font-weight: 500; margin: 0; font-size: 0.938rem;">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #f8d7da; border-left: 4px solid #dc3545 !important; padding: 1rem 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-exclamation-circle" style="color: #842029; font-size: 1.5rem;"></i>
                    <p style="color: #842029; font-weight: 500; margin: 0; font-size: 0.938rem;">{{ session('error') }}</p>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #f8d7da; border-left: 4px solid #dc3545 !important; padding: 1rem 1.5rem;">
                <div style="display: flex; align-items-start; gap: 1rem;">
                    <i class="fas fa-exclamation-circle" style="color: #842029; font-size: 1.5rem; margin-top: 0.125rem;"></i>
                    <div style="flex: 1;">
                        <p style="color: #842029; font-weight: 600; margin: 0 0 0.5rem 0; font-size: 0.938rem;">Please fix the following errors:</p>
                        <ul style="margin: 0; padding-left: 1.25rem; color: #842029; font-size: 0.875rem;">
                            @foreach($errors->all() as $error)
                                <li style="margin-bottom: 0.25rem;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Step Indicators -->
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #ffffff; padding: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.5rem;">
                <div style="flex: 1; display: flex; align-items: center; cursor: pointer;" @click="goToStep(1)">
                    <div class="step-indicator" style="width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.125rem; background: #e9ecef; color: #6c757d;"
                         :class="{'active': currentStep === 1, 'completed': currentStep > 1}">
                        <span x-show="currentStep <= 1">1</span>
                        <i class="fas fa-check" x-show="currentStep > 1"></i>
                    </div>
                    <div style="margin-left: 0.75rem; display: none;" class="d-none d-md-block">
                        <p style="font-size: 0.875rem; font-weight: 600; color: #212529; margin: 0;">Step 1</p>
                        <p style="font-size: 0.75rem; color: #6c757d; margin: 0;">Personal Info</p>
                    </div>
                </div>
                <div style="flex: 1; height: 2px; background: #e9ecef; margin: 0 0.5rem;" :class="{'bg-success': currentStep > 1}"></div>
                
                <div style="flex: 1; display: flex; align-items: center; cursor: pointer;" @click="goToStep(2)">
                    <div class="step-indicator" style="width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.125rem; background: #e9ecef; color: #6c757d;"
                         :class="{'active': currentStep === 2, 'completed': currentStep > 2}">
                        <span x-show="currentStep <= 2">2</span>
                        <i class="fas fa-check" x-show="currentStep > 2"></i>
                    </div>
                    <div style="margin-left: 0.75rem; display: none;" class="d-none d-md-block">
                        <p style="font-size: 0.875rem; font-weight: 600; color: #212529; margin: 0;">Step 2</p>
                        <p style="font-size: 0.75rem; color: #6c757d; margin: 0;">Address & Contact</p>
                    </div>
                </div>
                <div style="flex: 1; height: 2px; background: #e9ecef; margin: 0 0.5rem;" :class="{'bg-success': currentStep > 2}"></div>
                
                <div style="flex: 1; display: flex; align-items: center; cursor: pointer;" @click="goToStep(3)">
                    <div class="step-indicator" style="width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.125rem; background: #e9ecef; color: #6c757d;"
                         :class="{'active': currentStep === 3, 'completed': currentStep > 3}">
                        <span x-show="currentStep <= 3">3</span>
                        <i class="fas fa-check" x-show="currentStep > 3"></i>
                    </div>
                    <div style="margin-left: 0.75rem; display: none;" class="d-none d-md-block">
                        <p style="font-size: 0.875rem; font-weight: 600; color: #212529; margin: 0;">Step 3</p>
                        <p style="font-size: 0.75rem; color: #6c757d; margin: 0;">Documents</p>
                    </div>
                </div>
                <div style="flex: 1; height: 2px; background: #e9ecef; margin: 0 0.5rem;" :class="{'bg-success': currentStep > 3}"></div>
                
                <div style="flex: 1; display: flex; align-items: center; cursor: pointer;" @click="goToStep(4)">
                    <div class="step-indicator" style="width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.125rem; background: #e9ecef; color: #6c757d;"
                         :class="{'active': currentStep === 4, 'completed': currentStep > 4}">
                        <span x-show="currentStep <= 4">4</span>
                        <i class="fas fa-check" x-show="currentStep > 4"></i>
                    </div>
                    <div style="margin-left: 0.75rem; display: none;" class="d-none d-md-block">
                        <p style="font-size: 0.875rem; font-weight: 600; color: #212529; margin: 0;">Step 4</p>
                        <p style="font-size: 0.75rem; color: #6c757d; margin: 0;">Parent Info</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Form -->
        <form method="POST" action="{{ route('admission.store') }}" enctype="multipart/form-data" 
              @submit="handleSubmit">
            @csrf
            <input type="hidden" name="current_step" x-model="currentStep">

            <!-- STEP 1: Personal Information & National ID -->
            <div class="step-content" :class="{'active': currentStep === 1}">
                <!-- Step Header Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #ffffff; padding: 1.5rem; border-left: 4px solid #667eea !important;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #212529; margin: 0; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-user-circle" style="color: #667eea;"></i>
                        Step 1: Personal Information
                    </h3>
                </div>

                <!-- Form Fields Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #ffffff; padding: 2rem;">
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <!-- National ID -->
                        <div>
                            <label class="form-label">National ID (14 digits) *</label>
                            <input type="text" id="national_id" name="national_id" 
                                value="{{ old('national_id', $admission->national_id ?? '') }}" 
                                maxlength="14"
                                class="form-input"
                                style="width: 100%; font-family: 'Courier New', monospace; font-size: 1.125rem;"
                                placeholder="30125011234567"
                                @blur="validateField('national_id')">
                            <div id="national_id_error" class="error-message" style="display: none;"></div>
                            <p style="font-size: 0.813rem; color: #6c757d; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.375rem;">
                                <i class="fas fa-info-circle"></i> Birth date, governorate, and gender will be auto-filled
                            </p>
                        </div>

                        <!-- Auto-extracted fields -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                            <div>
                                <label class="form-label">Birth Date *</label>
                                <input type="date" id="birth_date" name="birth_date" 
                                    value="{{ old('birth_date', isset($admission) && $admission->birth_date ? $admission->birth_date->format('Y-m-d') : '') }}" 
                                    max="{{ date('Y-m-d') }}"
                                    class="form-input"
                                    style="width: 100%;"
                                    @blur="validateField('birth_date')">
                                <div id="birth_date_error" class="error-message" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="form-label">Birth Governorate *</label>
                                <input type="text" id="birth_governorate" name="birth_governorate" 
                                    value="{{ old('birth_governorate', $admission->birth_governorate ?? '') }}" 
                                    class="form-input"
                                    style="width: 100%;"
                                    @blur="validateField('birth_governorate')">
                                <div id="birth_governorate_error" class="error-message" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="form-label">Gender *</label>
                                <div style="display: flex; align-items: center; gap: 2rem; margin-top: 0.75rem;">
                                    <label style="display: flex; align-items: center; cursor: pointer;">
                                        <input type="radio" name="gender" value="male" 
                                            {{ old('gender', $admission->gender ?? '') === 'male' ? 'checked' : '' }} 
                                            style="width: 18px; height: 18px; cursor: pointer;">
                                        <span style="margin-left: 0.5rem; color: #495057; font-size: 0.938rem;">Male</span>
                                    </label>
                                    <label style="display: flex; align-items: center; cursor: pointer;">
                                        <input type="radio" name="gender" value="female" 
                                            {{ old('gender', $admission->gender ?? '') === 'female' ? 'checked' : '' }} 
                                            style="width: 18px; height: 18px; cursor: pointer;">
                                        <span style="margin-left: 0.5rem; color: #495057; font-size: 0.938rem;">Female</span>
                                    </label>
                                </div>
                                <div id="gender_error" class="error-message" style="display: none;"></div>
                            </div>
                        </div>

                        <!-- Full Name (Quadruple) -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                            <div>
                                <label class="form-label">First Name *</label>
                                <input type="text" name="first_name" id="first_name"
                                    value="{{ old('first_name', $admission->first_name ?? '') }}" 
                                    class="form-input"
                                    style="width: 100%;"
                                    @blur="validateField('first_name')">
                                <div id="first_name_error" class="error-message" style="display: none;"></div>
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
                                {{-- <option value="Jewish" {{ old('religion', $admission->religion ?? '') === 'Jewish' ? 'selected' : '' }}>Jewish</option> --}}
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
            <div class="card border-0 shadow-sm rounded-4" style="background: #ffffff; padding: 1.5rem 2rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                    <!-- Previous Button -->
                    <button type="button" @click="previousStep" x-show="currentStep > 1"
                        class="btn-secondary" style="display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-arrow-left"></i>
                        Previous
                    </button>
                    <div x-show="currentStep === 1"></div>

                    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                        <!-- Save as Draft Button -->
                        <button type="submit" name="save_draft" value="1"
                            style="background: #ffc107; color: #000; padding: 0.75rem 2rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.938rem; border: none; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 2px 4px rgba(255, 193, 7, 0.2);"
                            onmouseover="this.style.background='#ffb300'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(255, 193, 7, 0.3)';" 
                            onmouseout="this.style.background='#ffc107'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(255, 193, 7, 0.2)';">
                            <i class="fas fa-save"></i>
                            Save as Draft
                        </button>

                        <!-- Next Button -->
                        <button type="button" @click="nextStep" x-show="currentStep < 4"
                            class="btn-primary" style="display: flex; align-items: center; gap: 0.5rem;">
                            Next
                            <i class="fas fa-arrow-right"></i>
                        </button>

                        <!-- Submit Button -->
                        <button type="submit" x-show="currentStep === 4"
                            style="background: #198754; color: white; padding: 0.75rem 2rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.938rem; border: none; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 2px 4px rgba(25, 135, 84, 0.2);"
                            onmouseover="this.style.background='#157347'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(25, 135, 84, 0.3)';" 
                            onmouseout="this.style.background='#198754'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(25, 135, 84, 0.2)';">
                            <i class="fas fa-paper-plane"></i>
                            {{ isset($isReapplication) && $isReapplication ? 'Re-submit Application' : 'Submit Application' }}
                        </button>
                    </div>
                </div>
                <p style="text-align: center; font-size: 0.813rem; color: #6c757d; margin-top: 1rem; margin-bottom: 0;">
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
        uploadedFileHashes: {}, // Track file signatures (name + size) to prevent duplicates
        
        init() {
            // Restore file names if validation failed
            this.restoreFileNames();
            // Initialize National ID listener for auto-gender extraction
            this.initNationalIdListener();
            // Initialize phone comparison listeners
            this.initPhoneComparisonListeners();
            // #region agent log
            this.$nextTick(() => {
                const steps = document.querySelectorAll('.step-content');
                fetch('http://127.0.0.1:7377/ingest/384d8071-d4dc-44ea-b25c-b295b7c44c9c',{method:'POST',headers:{'Content-Type':'application/json','X-Debug-Session-Id':'1fa0fa'},body:JSON.stringify({sessionId:'1fa0fa',location:'create.blade.php:init',message:'Wizard DOM structure on init',data:{stepCount:steps.length,step2NestedInStep1:steps[0]&&steps[1]?steps[0].contains(steps[1]):null,step1ChildCount:steps[0]?steps[0].querySelectorAll(':scope > .step-content').length:0},timestamp:Date.now(),hypothesisId:'H1'})}).catch(()=>{});
            });
            // #endregion
        },
        
        // National ID Auto-Gender Extraction
        initNationalIdListener() {
            const nationalIdField = document.getElementById('national_id');
            if (nationalIdField) {
                nationalIdField.addEventListener('input', (e) => {
                    const nationalId = e.target.value;
                    if (nationalId.length === 14 && /^\d{14}$/.test(nationalId)) {
                        // Extract 13th digit (index 12) for gender
                        const genderDigit = parseInt(nationalId.charAt(12));
                        const maleRadio = document.querySelector('input[name="gender"][value="male"]');
                        const femaleRadio = document.querySelector('input[name="gender"][value="female"]');
                        
                        if (genderDigit % 2 === 1) {
                            // Odd = Male
                            if (maleRadio) maleRadio.checked = true;
                        } else {
                            // Even = Female
                            if (femaleRadio) femaleRadio.checked = true;
                        }
                        
                        // Clear any gender error
                        const genderError = document.getElementById('gender_error');
                        if (genderError) genderError.classList.add('hidden');
                    }
                });
            }
        },
        
        // Phone Comparison Validation
        initPhoneComparisonListeners() {
            const studentPhone = document.getElementById('phone');
            const parentPhone = document.getElementById('parent_phone');
            
            if (studentPhone && parentPhone) {
                const checkPhoneDifference = () => {
                    const studentValue = studentPhone.value.trim();
                    const parentValue = parentPhone.value.trim();
                    
                    if (studentValue && parentValue && studentValue === parentValue) {
                        const errorMsg = 'رقم هاتف الطالب يجب أن يكون مختلفاً عن رقم هاتف ولي الأمر! / Student phone must be different from parent phone.';
                        
                        // Show error on both fields
                        this.showFieldError('phone', errorMsg);
                        this.showFieldError('parent_phone', errorMsg);
                        
                        return false;
                    }
                    return true;
                };
                
                studentPhone.addEventListener('blur', checkPhoneDifference);
                parentPhone.addEventListener('blur', checkPhoneDifference);
            }
        },
        
        showFieldError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const errorDiv = document.getElementById(fieldId + '_error');
            
            if (field && errorDiv) {
                errorDiv.textContent = message;
                errorDiv.classList.remove('hidden');
                field.classList.add('input-error');
            }
        },
        
        goToStep(step) {
            // Allow clicking on completed steps or the next step
            if (step <= this.currentStep || step === this.currentStep + 1) {
                // Validate before allowing forward navigation
                if (step > this.currentStep) {
                    if (this.validateCurrentStep()) {
                        this.currentStep = step;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                } else {
                    this.currentStep = step;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        },
        
        nextStep() {
            const stepBefore = this.currentStep;
            if (this.validateCurrentStep()) {
                this.currentStep++;
                // #region agent log
                this.$nextTick(() => {
                    const steps = document.querySelectorAll('.step-content');
                    const target = steps[this.currentStep - 1];
                    fetch('http://127.0.0.1:7377/ingest/384d8071-d4dc-44ea-b25c-b295b7c44c9c',{method:'POST',headers:{'Content-Type':'application/json','X-Debug-Session-Id':'1fa0fa'},body:JSON.stringify({sessionId:'1fa0fa',location:'create.blade.php:nextStep',message:'Step navigation',data:{stepBefore,stepAfter:this.currentStep,targetHasActive:target?target.classList.contains('active'):null,targetDisplay:target?getComputedStyle(target).display:null,parentHidden:target?.parentElement?getComputedStyle(target.parentElement).display==='none':null},timestamp:Date.now(),hypothesisId:'H2'})}).catch(()=>{});
                });
                // #endregion
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
            
            // Clear all errors first
            requiredFields.forEach(fieldId => {
                const errorDiv = document.getElementById(fieldId + '_error');
                if (errorDiv) errorDiv.classList.add('hidden');
                const field = document.getElementById(fieldId);
                if (field) field.classList.remove('input-error');
            });
            
            // Validate all fields
            requiredFields.forEach(fieldId => {
                if (!this.validateField(fieldId)) {
                    isValid = false;
                }
            });
            
            // Special validation for phone comparison in Step 1 and 4
            if (this.currentStep === 1 || this.currentStep === 4) {
                const studentPhone = document.getElementById('phone');
                const parentPhone = document.getElementById('parent_phone');
                
                if (studentPhone && parentPhone && studentPhone.value && parentPhone.value) {
                    if (studentPhone.value.trim() === parentPhone.value.trim()) {
                        const errorMsg = 'رقم هاتف الطالب يجب أن يكون مختلفاً عن رقم هاتف ولي الأمر! / Student phone must be different from parent phone.';
                        this.showFieldError('phone', errorMsg);
                        this.showFieldError('parent_phone', errorMsg);
                        isValid = false;
                    }
                }
            }
            
            if (!isValid) {
                alert('⚠️ Please fix all errors before proceeding to the next step.\nالرجاء تصحيح جميع الأخطاء قبل الانتقال إلى الخطوة التالية.');
                // Scroll to first error
                const firstError = document.querySelector('.input-error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
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
                    errorMessage = 'This field is required. / هذا الحقل مطلوب.';
                }
            } else if (!field.value || field.value.trim() === '') {
                isValid = false;
                errorMessage = 'This field is required. / هذا الحقل مطلوب.';
            } else {
                // Field-specific validation
                switch(fieldId) {
                    case 'national_id':
                        if (!/^\d{14}$/.test(field.value)) {
                            isValid = false;
                            errorMessage = 'National ID must be exactly 14 digits. / الرقم القومي يجب أن يكون 14 رقماً.';
                        }
                        break;
                    case 'phone':
                    case 'parent_phone':
                        if (!/^(010|011|012|015)\d{8}$/.test(field.value)) {
                            isValid = false;
                            errorMessage = 'Phone must be 11 digits starting with 010, 011, 012, or 015. / رقم الهاتف يجب أن يبدأ بـ 010 أو 011 أو 012 أو 015.';
                        }
                        break;
                    case 'birth_date':
                        const birthDate = new Date(field.value);
                        const today = new Date();
                        if (birthDate >= today) {
                            isValid = false;
                            errorMessage = 'Birth date must be in the past. / تاريخ الميلاد يجب أن يكون في الماضي.';
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
            const errorDiv = document.getElementById(fieldId + '_error');
            
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileSignature = `${file.name}_${file.size}`;
                
                // Check for duplicate files
                const existingFile = Object.entries(this.uploadedFileHashes).find(
                    ([key, signature]) => key !== fieldId && signature === fileSignature
                );
                
                if (existingFile) {
                    // Duplicate detected!
                    fileInput.value = ''; // Clear the input
                    if (errorDiv) {
                        errorDiv.textContent = '⚠️ لا يمكن رفع نفس الملف مرتين! / Cannot upload the exact same file twice!';
                        errorDiv.classList.remove('hidden');
                        fileInput.classList.add('input-error');
                    }
                    alert('⚠️ لا يمكن رفع نفس الملف مرتين!\n\nCannot upload the exact same file twice!\n\nPlease select a different file.');
                    return false;
                }
                
                // File is unique, store it
                this.uploadedFiles[fieldId] = file.name;
                this.uploadedFileHashes[fieldId] = fileSignature;
                
                // Store in sessionStorage to persist across page reloads
                sessionStorage.setItem('uploaded_' + fieldId, file.name);
                sessionStorage.setItem('uploaded_hash_' + fieldId, fileSignature);
                
                // Clear any error
                if (errorDiv) {
                    errorDiv.classList.add('hidden');
                    fileInput.classList.remove('input-error');
                }
                
                return true;
            }
        },
        
        restoreFileNames() {
            // Restore file names and hashes from sessionStorage after validation failure
            const fileFields = ['student_photo', 'birth_certificate', 'qualification_certificate', 'student_id_document', 'parent_id_document'];
            fileFields.forEach(fieldId => {
                const storedName = sessionStorage.getItem('uploaded_' + fieldId);
                const storedHash = sessionStorage.getItem('uploaded_hash_' + fieldId);
                if (storedName) {
                    this.uploadedFiles[fieldId] = storedName;
                }
                if (storedHash) {
                    this.uploadedFileHashes[fieldId] = storedHash;
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
            const invalidSteps = [];
            
            for (let step = 1; step <= 4; step++) {
                const requiredFields = this.getRequiredFieldsForStep(step);
                let stepValid = true;
                
                requiredFields.forEach(fieldId => {
                    if (!this.validateField(fieldId)) {
                        allValid = false;
                        stepValid = false;
                    }
                });
                
                if (!stepValid) {
                    invalidSteps.push(step);
                }
            }
            
            // Check phone comparison one final time
            const studentPhone = document.getElementById('phone');
            const parentPhone = document.getElementById('parent_phone');
            if (studentPhone && parentPhone && studentPhone.value && parentPhone.value) {
                if (studentPhone.value.trim() === parentPhone.value.trim()) {
                    const errorMsg = 'رقم هاتف الطالب يجب أن يكون مختلفاً عن رقم هاتف ولي الأمر! / Student phone must be different from parent phone.';
                    this.showFieldError('phone', errorMsg);
                    this.showFieldError('parent_phone', errorMsg);
                    allValid = false;
                    if (!invalidSteps.includes(1)) invalidSteps.push(1);
                    if (!invalidSteps.includes(4)) invalidSteps.push(4);
                }
            }
            
            if (!allValid) {
                event.preventDefault();
                alert(`⚠️ Please complete all required fields before submitting.\nالرجاء إكمال جميع الحقول المطلوبة قبل التقديم.\n\nErrors found in Step(s): ${invalidSteps.join(', ')}`);
                // Jump to first invalid step
                if (invalidSteps.length > 0) {
                    this.currentStep = Math.min(...invalidSteps);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
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
