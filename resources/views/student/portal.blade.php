<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Application - {{ config('app.name') }}</title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Student Portal CSS -->
    <link rel="stylesheet" href="{{ asset('css/student-portal.css') }}">

    <style>
        /* Premium Minimal Navbar Styles */
        .navbar-minimal {
            background: linear-gradient(135deg, #1a3a6e 0%, #2356c7 100%);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .navbar-shadow {
            box-shadow: 0 2px 16px rgba(26,58,110,0.3);
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
            color: rgba(255,255,255,0.85);
            font-weight: 500;
            font-size: 0.938rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.12);
            color: #ffffff;
        }

        .nav-link i {
            color: rgba(255,255,255,0.7);
            margin-right: 0.5rem;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1a3a6e 0%, #2356c7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 0.875rem;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .user-info-text {
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .user-status-text {
            color: rgba(255,255,255,0.65);
            font-size: 0.75rem;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
            min-width: 220px;
            z-index: 50;
            overflow: hidden;
        }

        .dropdown-menu.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            color: #495057;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            color: #212529;
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 0.75rem;
            color: #6c757d;
        }

        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 0.5rem;
        }

        .status-pending { background: #ffc107; }
        .status-accepted { background: #198754; }
        .status-rejected { background: #dc3545; }

        .mobile-menu {
            display: none;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo i {
            color: #D08301;
            font-size: 1.25rem;
        }

        .brand-text {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.125rem;
            line-height: 1.2;
        }

        .brand-subtext {
            color: rgba(255,255,255,0.65);
            font-size: 0.75rem;
        }

        @media (max-width: 768px) {
            .desktop-menu {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .mobile-menu-content {
                display: none;
                background: white;
                border-radius: 0.75rem;
                margin-top: 1rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                border: 1px solid #e9ecef;
            }

            .mobile-menu-content.show {
                display: block;
                animation: slideDown 0.3s ease;
            }
        }
        
        /* Premium Profile Avatar Styles */
        .profile-avatar-wrapper {
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .profile-avatar-wrapper:hover img {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .profile-avatar-wrapper:hover .fa-camera {
            animation: pulse 0.6s infinite;
        }
        
        .profile-avatar-wrapper:hover .camera-icon-wrapper {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }
        
        .profile-avatar-wrapper:hover .camera-icon-wrapper .fa-camera {
            color: #ffffff !important;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }
        
        .profile-avatar-wrapper img {
            transition: all 0.3s ease;
        }
        
        .profile-avatar-wrapper:active img {
            transform: scale(0.98);
        }
    </style>
</head>
<body style="background: #f8f9fa; min-height: 100vh;">
    <!-- Premium Minimal Navbar -->
    <nav class="navbar-minimal navbar-shadow sticky top-0 z-40 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between" style="height: 64px;">
                <!-- Logo & Brand -->
                <div class="flex items-center">
                    <div class="brand-logo">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="ml-3">
                        <h1 class="brand-text">Student Portal</h1>
                        <p class="brand-subtext">{{ config('app.name') }}</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="desktop-menu flex items-center" style="gap: 1rem;">
                    <!-- Navigation Links -->
                    <a href="{{ route('home') }}" class="nav-link flex items-center">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>

                    <!-- User Profile Info with Logout -->
                    <div class="flex items-center" style="gap: 0.75rem; padding: 0.375rem 0.75rem; margin-left: 1rem;">
                        <!-- Dynamic Profile Avatar -->
                        @if($admission && $admission->student_photo)
                            <img src="{{ asset($admission->student_photo) }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="rounded-full object-cover" 
                                 style="width: 38px; height: 38px; border: 2px solid #D08301;">
                        @else
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        
                        <div class="text-left hidden lg:block">
                            <p class="user-info-text">{{ auth()->user()->name }}</p>
                            @if($admission)
                            <p class="user-status-text flex items-center">
                                <span class="status-indicator status-{{ $admission->status }}"></span>
                                {{ ucfirst($admission->status) }}
                            </p>
                            @endif
                        </div>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" style="background:#fff;color:#1a3a6e;border:2px solid rgba(255,255,255,0.4);padding:8px 16px;border-radius:8px;font-size:0.82rem;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;transition:all 0.2s;" onmouseover="this.style.background='#D08301';this.style.color='#fff';this.style.borderColor='#D08301'" onmouseout="this.style.background='#fff';this.style.color='#1a3a6e';this.style.borderColor='rgba(255,255,255,0.4)'">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="hidden lg:inline">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="mobile-menu">
                    <button id="mobileMenuBtn" class="p-2 rounded-lg hover:bg-gray-100 focus:outline-none">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu Content -->
            {{-- <div id="mobileMenu" class="mobile-menu-content">
                <div class="p-4">
                    <div class="flex items-center space-x-3 pb-4 border-b border-gray-200">
                        @if($admission && $admission->student_photo)
                            <img src="{{ asset($admission->student_photo) }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="rounded-full object-cover" 
                                 style="width: 38px; height: 38px; border: 2px solid #e9ecef;">
                        @else
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            @if($admission)
                            <p class="text-xs flex items-center mt-1">
                                <span class="status-indicator status-{{ $admission->status }}"></span>
                                {{ ucfirst($admission->status) }}
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="py-2">
                        <a href="{{ route('home') }}" class="dropdown-item">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </a>

                        <a href="{{ route('student.portal') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>My Profile</span>
                        </a>

                        @if($admission)
                        <a href="{{ route('student.portal') }}" class="dropdown-item">
                            <i class="fas fa-file-alt"></i>
                            <span>Application Status</span>
                        </a>
                        @else
                        <a href="{{ route('admission.create') }}" class="dropdown-item">
                            <i class="fas fa-plus-circle"></i>
                            <span>Submit Application</span>
                        </a>
                        @endif

                        <div class="border-t border-gray-100 my-2"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item w-full text-left" style="color: #dc3545;">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg no-print">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-2xl mr-3"></i>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg no-print">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-3"></i>
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg no-print">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl mr-3 mt-1"></i>
                    <div class="flex-1">
                        <p class="text-red-700 font-medium mb-2">Please fix the following errors:</p>
                        <ul class="list-disc list-inside text-red-600 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if(!$admission)
            <!-- Empty State: No Application -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-900 via-blue-700 to-blue-600 px-8 py-16 text-center" style="background: linear-gradient(135deg, #1a3a6e 0%, #2356c7 100%) !important;">
                    <div class="inline-block p-6 bg-white bg-opacity-20 rounded-full mb-6">
                        <i class="fas fa-file-alt text-white text-6xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-4">Welcome to Your Student Portal</h2>
                    <p class="text-white text-opacity-90 text-lg mb-8">You haven't submitted an application yet. Start your journey with us today!</p>
                </div>

                <div class="p-12 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Ready to Apply?</h3>
                    <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                        Complete your admission application in just a few steps. Our easy-to-use form will guide you through the process.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 max-w-4xl mx-auto">
                        <div class="p-6 bg-blue-50 rounded-lg">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user text-white text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Personal Info</h4>
                            <p class="text-sm text-gray-600">Provide your basic information and contact details</p>
                        </div>

                        <div class="p-6 bg-green-50 rounded-lg">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-file-upload text-white text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Upload Documents</h4>
                            <p class="text-sm text-gray-600">Submit required certificates and identification</p>
                        </div>

                        <div class="p-6 bg-purple-50 rounded-lg">
                            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Submit & Track</h4>
                            <p class="text-sm text-gray-600">Submit your application and track its status</p>
                        </div>
                    </div>

                    <a href="{{ route('admission.create') }}"
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-lg font-bold rounded-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition duration-200 shadow-lg">
                        <i class="fas fa-rocket mr-3"></i>
                        Start New Application
                    </a>

                    <p class="text-sm text-gray-500 mt-6">
                        <i class="fas fa-save mr-1"></i> You can save your progress as a draft and continue later
                    </p>
                </div>
            </div>
        @elseif($isDraft)
            <!-- Draft State: Continue Application -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-8 py-12 text-center">
                    <div class="inline-block p-6 bg-white bg-opacity-20 rounded-full mb-6">
                        <i class="fas fa-edit text-white text-6xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-4">Continue Your Application</h2>
                    <p class="text-white text-opacity-90 text-lg mb-8">You have a draft application saved. Pick up where you left off!</p>
                </div>

                <div class="p-8 text-center">
                    <div class="mb-6">
                        <p class="text-gray-700 text-lg mb-2">Current Progress: <strong>Step {{ $admission->current_step }} of 4</strong></p>
                        <div class="w-full bg-gray-200 rounded-full h-4 max-w-md mx-auto">
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-4 rounded-full transition-all duration-300"
                                 style="width: {{ ($admission->current_step / 4) * 100 }}%"></div>
                        </div>
                    </div>

                    <a href="{{ route('admission.create') }}"
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-lg font-bold rounded-lg hover:from-yellow-600 hover:to-orange-600 transform hover:scale-105 transition duration-200 shadow-lg">
                        <i class="fas fa-edit mr-3"></i>
                        Continue Application
                    </a>

                    <p class="text-sm text-gray-500 mt-6">
                        Last saved: {{ $admission->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        @elseif($admission)
            <!-- Rejection Alert (shown above profile card when rejected with reason) -->
            @if($admission->status === 'rejected' && $admission->rejection_reason)
                <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-xl mb-6 shadow-sm no-print">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-bold text-red-900 mb-2">Application Rejected</h3>
                            <p class="text-sm font-semibold text-red-800 mb-1">Rejection Reason:</p>
                            <p class="text-red-700 leading-relaxed">{{ $admission->rejection_reason }}</p>
                            <div class="mt-4 flex items-center gap-3">
                                <a href="{{ route('admission.create') }}"
                                   class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm">
                                    <i class="fas fa-redo mr-2"></i>
                                    Resubmit Application
                                </a>
                                <p class="text-sm text-red-600">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Your previous data will be pre-filled
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- ===== HERO PROFILE CARD ===== -->
            <div style="background: linear-gradient(135deg, #1a3a6e 0%, #2356c7 100%); border-radius: 20px; padding: 32px 36px; margin-bottom: 24px; position: relative; overflow: hidden; box-shadow: 0 8px 32px rgba(26,58,110,0.25);">
                <!-- decorative circles -->
                <div style="position:absolute;top:-60px;right:-60px;width:200px;height:200px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
                <div style="position:absolute;bottom:-40px;left:-40px;width:150px;height:150px;background:rgba(255,255,255,0.04);border-radius:50%;"></div>

                <div style="display:flex;align-items:center;gap:28px;flex-wrap:wrap;position:relative;z-index:1;">
                    <!-- Photo -->
                    <form action="{{ route('student.update-photo') }}" method="POST" enctype="multipart/form-data" id="photoUpdateForm">
                        @csrf
                        <input type="file" 
                               name="student_photo" 
                               id="profile_image_input"
                               data-vibe-crop
                               data-vibe-crop-width="400"
                               data-vibe-crop-height="400"
                               style="display:none;" 
                               accept="image/jpeg,image/png,image/jpg"
                               onchange="handlePhotoUploadSimple(this);">
                        <label for="profile_image_input" id="profilePhotoDisplay"
                               style="cursor:pointer;display:block;position:relative;width:110px;height:110px;flex-shrink:0;"
                               title="Click to change photo" class="profile-avatar-wrapper">
                            @if($admission && $admission->student_photo)
                                <img src="{{ asset($admission->student_photo) }}"
                                     alt="Student Photo"
                                     style="width:110px;height:110px;border-radius:50%;object-fit:cover;border:4px solid #D08301;box-shadow:0 6px 20px rgba(0,0,0,0.3);">
                            @else
                                <div style="width:110px;height:110px;border-radius:50%;background:rgba(255,255,255,0.15);border:4px solid #D08301;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 20px rgba(0,0,0,0.2);">
                                    <i class="fas fa-user" style="font-size:2.5rem;color:rgba(255,255,255,0.7);"></i>
                                </div>
                            @endif
                            <!-- Camera overlay -->
                            <div class="camera-icon-wrapper" style="position:absolute;bottom:4px;right:4px;width:30px;height:30px;background:#D08301;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.2);transition:all 0.3s ease;">
                                <i class="fas fa-camera" style="font-size:11px;color:#fff;"></i>
                            </div>
                        </label>
                    </form>

                    <!-- Info -->
                    <div style="flex:1;min-width:200px;">
                        <h2 style="color:#fff;font-weight:800;font-size:1.4rem;margin:0 0 6px;text-shadow:0 2px 8px rgba(0,0,0,0.2);">
                            {{ $admission->full_name }}
                        </h2>
                        <p style="color:rgba(255,255,255,0.75);font-size:0.85rem;margin:0 0 12px;font-family:monospace;">
                            <i class="fas fa-id-card me-1"></i>{{ $admission->national_id }}
                        </p>

                        <!-- Status Badge -->
                        @if($admission->status === 'pending')
                            <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,193,7,0.2);color:#ffc107;border:1px solid rgba(255,193,7,0.4);padding:6px 16px;border-radius:20px;font-size:0.8rem;font-weight:700;">
                                <i class="fas fa-clock"></i> Under Review
                            </span>
                        @elseif($admission->status === 'accepted')
                            <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(25,135,84,0.2);color:#5bdd9b;border:1px solid rgba(25,135,84,0.4);padding:6px 16px;border-radius:20px;font-size:0.8rem;font-weight:700;">
                                <i class="fas fa-check-circle"></i> Accepted
                            </span>
                        @elseif($admission->status === 'rejected')
                            <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(220,53,69,0.2);color:#ff6b7a;border:1px solid rgba(220,53,69,0.4);padding:6px 16px;border-radius:20px;font-size:0.8rem;font-weight:700;">
                                <i class="fas fa-times-circle"></i> Rejected
                            </span>
                        @endif
                    </div>

                    <!-- Student Code -->
                    @if($admission->status === 'accepted' && $admission->student_code)
                    <div style="background:rgba(255,255,255,0.1);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.2);border-radius:14px;padding:18px 28px;text-align:center;flex-shrink:0;">
                        <p style="color:rgba(255,255,255,0.65);font-size:0.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin:0 0 6px;">Student Code</p>
                        <p style="color:#D08301;font-size:1.5rem;font-weight:800;font-family:monospace;letter-spacing:3px;margin:0;text-shadow:0 2px 8px rgba(0,0,0,0.2);">
                            {{ $admission->student_code }}
                        </p>
                    </div>
                    @endif

                </div>
            </div>

            <!-- Status Message Card -->
            @if($admission->status === 'pending')
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-yellow-600 text-xl mr-3 mt-0.5"></i>
                        <p class="text-yellow-800 text-sm leading-relaxed">
                            Your application is being reviewed by our admissions team. We'll notify you via email once a decision is made.
                        </p>
                    </div>
                </div>
            @elseif($admission->status === 'accepted')
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-0.5"></i>
                        <div>
                            <p class="text-green-900 font-semibold mb-1">
                                Congratulations! Your application has been accepted.
                            </p>
                            <p class="text-green-800 text-sm">
                                Check your email for your Student Code and next steps.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Information Cards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Personal Information Card -->
                <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-user-circle mr-3"></i>
                            Personal Information
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-id-card text-blue-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">National ID</div>
                                <div class="text-gray-900 font-mono">{{ $admission->national_id }}</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-blue-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">Email</div>
                                <div class="text-gray-900">{{ $admission->email }}</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone text-blue-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">Phone</div>
                                <div class="text-gray-900">{{ $admission->phone }}</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-birthday-cake text-blue-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">Birth Date</div>
                                <div class="text-gray-900">{{ $admission->birth_date->format('M d, Y') }}</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-venus-mars text-blue-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">Gender</div>
                                <div class="text-gray-900">{{ ucfirst($admission->gender) }}</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-pray text-blue-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">Religion</div>
                                <div class="text-gray-900">{{ $admission->religion }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information Card -->
                <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-map-marker-alt mr-3"></i>
                            Address Information
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-pin text-green-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">Birth Governorate</div>
                                <div class="text-gray-900">{{ $admission->birth_governorate }}</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-building text-green-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">Current Governorate</div>
                                <div class="text-gray-900">{{ $admission->current_governorate }}</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-city text-green-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">City/Center</div>
                                <div class="text-gray-900">{{ $admission->city_center }}</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-home text-green-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">Village/District</div>
                                <div class="text-gray-900">{{ $admission->village_district }}</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-road text-green-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">Street Address</div>
                                <div class="text-gray-900">{{ $admission->street_address }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parent/Guardian Information Card -->
                <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-users mr-3"></i>
                            Parent/Guardian Information
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user text-purple-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">Parent Name</div>
                                <div class="text-gray-900">{{ $admission->parent_name }}</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone-alt text-purple-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">Parent Phone</div>
                                <div class="text-gray-900">{{ $admission->parent_phone }}</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-briefcase text-purple-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-semibold text-gray-500">Father's Occupation</div>
                                <div class="text-gray-900">{{ $admission->father_occupation }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Card -->
                <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-file-alt mr-3"></i>
                            Uploaded Documents
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-gray-900 font-medium">Birth Certificate</div>
                                <div class="text-xs text-gray-500">Uploaded: {{ $admission->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-gray-900 font-medium">Qualification Certificate</div>
                                <div class="text-xs text-gray-500">Uploaded: {{ $admission->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-gray-900 font-medium">Student ID Document</div>
                                <div class="text-xs text-gray-500">Uploaded: {{ $admission->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-gray-900 font-medium">Parent ID Document</div>
                                <div class="text-xs text-gray-500">Uploaded: {{ $admission->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-gray-900 font-medium">Student Photo</div>
                                <div class="text-xs text-gray-500">Uploaded: {{ $admission->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Card -->
                <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden lg:col-span-2">
                    <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-history mr-3"></i>
                            Application Timeline
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="text-gray-900 font-semibold">Application Submitted</div>
                                    <div class="text-sm text-gray-500">{{ $admission->created_at->format('M d, Y \a\t h:i A') }}</div>
                                </div>
                            </div>

                            @if($admission->reviewed_at)
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 
                                        @if($admission->status === 'accepted') bg-green-500
                                        @elseif($admission->status === 'rejected') bg-red-500
                                        @else bg-gray-500
                                        @endif
                                        rounded-full flex items-center justify-center">
                                        <i class="fas 
                                            @if($admission->status === 'accepted') fa-check-circle
                                            @elseif($admission->status === 'rejected') fa-times-circle
                                            @else fa-eye
                                            @endif
                                            text-white"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="text-gray-900 font-semibold">
                                        @if($admission->status === 'accepted')
                                            Application Accepted
                                        @elseif($admission->status === 'rejected')
                                            Application Rejected
                                        @else
                                            Application Reviewed
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $admission->reviewed_at->format('M d, Y \a\t h:i A') }}</div>
                                </div>
                            </div>
                            @else
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="text-gray-400 font-semibold">Under Review</div>
                                    <div class="text-sm text-gray-400">Pending</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Delete Button (Only for Pending) -->
                @if($admission->status === 'pending')
                <div class="lg:col-span-2 no-print">
                    <div class="bg-white shadow-sm rounded-xl border-2 border-red-200 p-6 text-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Delete Application</h4>
                        <p class="text-gray-600 mb-6">You can delete your application and submit a new one if needed.</p>
                        <button onclick="showDeleteModal()"
                            class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition shadow-sm">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Delete Application
                        </button>
                    </div>
                </div>
                @endif
            </div>

        @else
            <!-- No Application -->
            <div class="info-card text-center py-16">
                <i class="fas fa-file-alt text-gray-300 text-6xl mb-6"></i>
                <h3 class="text-2xl font-semibold text-gray-700 mb-3">No Application Found</h3>
                <p class="text-gray-600 mb-8">You haven't submitted an admission application yet.</p>
                <a href="{{ route('admission.create') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition font-semibold text-lg shadow-lg">
                    <i class="fas fa-plus-circle mr-3"></i>
                    Submit Application
                </a>
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    @if($admission && $admission->status === 'pending')
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all">
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Delete Application?</h3>
                <p class="text-gray-600">Are you sure you want to delete your application? This action cannot be undone.</p>
            </div>

            <form method="POST" action="{{ route('student.application.delete') }}">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="hideDeleteModal()"
                        class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                        Yes, Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <script>
        // تشغيل القفل والفتح عن طريق الـ ID المباشر
document.getElementById('dropdownBtn').addEventListener('click', function(e) {
    e.stopPropagation(); // بتمنع دمج النقرات عشان ما يقفلش في نفس اللحظة
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('show');
});

// القفل عند الضغط في أي مكان برة
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('userDropdown');
    const button = document.getElementById('dropdownBtn');

    // لو الضغطة مش على الزرار ومش جوه المنيو، اقفلها فوراً
    if (!button.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.remove('show');
    }
});
    // function showDeleteModal() {
    //     document.getElementById('deleteModal').classList.remove('hidden');
    // }

    // function hideDeleteModal() {
    //     document.getElementById('deleteModal').classList.add('hidden');
    // }

    // // Dropdown toggle
    // function toggleDropdown() {
    //     const dropdown = document.getElementById('userDropdown');
    //     dropdown.classList.toggle('show');
    // }

    // // Mobile menu toggle
    // function toggleMobileMenu() {
    //     const mobileMenu = document.getElementById('mobileMenu');
    //     mobileMenu.classList.toggle('show');
    // }

    // // Close dropdown when clicking outside
    // document.addEventListener('click', function(event) {
    //     const dropdown = document.getElementById('userDropdown');
    //     const button = event.target.closest('button[onclick="toggleDropdown()"]');

    //     if (!button && dropdown && !dropdown.contains(event.target)) {
    //         dropdown.classList.remove('show');
    //     }
    // });

    // // Close mobile menu when clicking outside
    // document.addEventListener('click', function(event) {
    //     const mobileMenu = document.getElementById('mobileMenu');
    //     const button = event.target.closest('button[onclick="toggleMobileMenu()"]');
    
    // Mobile Menu Handler Only
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('show');
            });
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenu.classList.remove('show');
                }
            });
        }
    });
    
    // Simplified Photo Upload Handler - DON'T auto-submit, let cropper handle it
    function handlePhotoUploadSimple(input) {
        // The vibe-cropper will handle the file automatically
        // We just validate here
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                alert('⚠️ Please upload a valid image file (JPEG, PNG, or JPG).');
                input.value = '';
                return;
            }
            
            // Validate file size (max 2MB)
            if (file.size > 2048 * 1024) {
                alert('⚠️ File size must be less than 2MB.');
                input.value = '';
                return;
            }
            
            // Don't submit yet - let the cropper modal open first
            // After cropping, the vibe-cropper:done event will trigger
        }
    }
    </script>
    
    @include('components.vibe-cropper-assets')
    
    <script>
    // When cropper is done, auto-submit the form
    document.getElementById('profile_image_input')?.addEventListener('vibe-cropper:done', function (event) {
        console.log('✅ Cropper done, submitting form...');
        
        // Show loading state
        const photoDisplay = document.getElementById('profilePhotoDisplay');
        if (photoDisplay) {
            const overlay = document.createElement('div');
            overlay.style.cssText = 'position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.9); display: flex; align-items: center; justify-content: center; border-radius: 50%;';
            overlay.innerHTML = '<i class="fas fa-spinner fa-spin text-2xl text-blue-600"></i>';
            photoDisplay.appendChild(overlay);
        }
        
        // Submit the form with the cropped image
        setTimeout(() => {
            document.getElementById('photoUpdateForm').submit();
        }, 300);
    });
    </script>
</body>
</html>
