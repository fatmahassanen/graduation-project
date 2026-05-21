<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'NCTU') }}</title>

    <!-- FontAwesome 5.10.0 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">

    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Typography consistency */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Sidebar navigation items */
        .nav-item {
            transition: all 0.3s ease;
            font-size: 0.9375rem;
            font-weight: 500;
            line-height: 1.5;
            letter-spacing: 0.01em;
        }

        .nav-item:hover {
            background-color: #D08301 !important;
            padding-left: 1.75rem;
        }

        .nav-item.active {
            background-color: #D08301;
            border-left: 4px solid #ffffff;
            font-weight: 600;
        }

        .nav-item i {
            font-size: 1.125rem;
            width: 1.25rem;
            text-align: center;
        }

        /* Mobile toggle button */
        .mobile-toggle {
            border: 1px solid transparent;
        }

        .mobile-toggle:hover {
            background-color: #f3f4f6 !important;
            border-color: #e5e7eb;
        }

        .mobile-toggle:focus {
            outline: 2px solid #D08301;
            outline-offset: 2px;
            border-color: #D08301;
        }

        /* Content area */
        .content-area {
            background-color: #f4f7f6;
            margin-top: 64px;
            padding: 1.5rem;
            min-height: calc(100vh - 64px);
        }

        @media (min-width: 768px) {
            .content-area {
                padding: 2rem;
            }
        }

        /* Sidebar styling */
        .sidebar {
            transition: transform 0.3s ease;
            z-index: 1001;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Custom scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Firefox scrollbar */
        .sidebar {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.05);
        }

        .sidebar-nav {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .sidebar-nav a:not(:last-child) {
            margin-bottom: 0.25rem;
        }

        @media (max-width: 767px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }
        }

        /* Sidebar overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Focus visible for keyboard navigation */
        *:focus-visible {
            outline: 2px solid #D08301;
            outline-offset: 2px;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Top Header -->
    <header class="top-header fixed top-0 left-0 right-0 bg-white h-16" style="z-index: 1000;">
        <div class="header-content h-full flex items-center justify-between px-4 md:px-6">
            <!-- Mobile Toggle Button -->
            <button class="mobile-toggle md:hidden flex items-center justify-center w-10 h-10 rounded-lg transition-all duration-200" onclick="toggleSidebar(event)" aria-label="Toggle sidebar">
                <i class="fas fa-bars text-gray-700 text-xl"></i>
            </button>

            <!-- Right Side Buttons -->
            <div class="ml-auto flex items-center gap-3">
                <!-- View Website Button -->
                @php
                    $routeName = Route::currentRouteName();
                    $frontendUrl = '/';
                    
                    // Map admin routes to frontend routes
                    if (str_contains($routeName, 'admin.events')) {
                        $frontendUrl = route('events');
                    } elseif (str_contains($routeName, 'admin.news')) {
                        $frontendUrl = route('news');
                    } elseif (str_contains($routeName, 'admin.departments')) {
                        $frontendUrl = route('home');
                    } elseif (str_contains($routeName, 'admin.gallery')) {
                        $frontendUrl = route('gallery');
                    } elseif (str_contains($routeName, 'admin.trainings')) {
                        $frontendUrl = route('trainings');
                    } elseif (str_contains($routeName, 'admin.activities')) {
                        $frontendUrl = route('activities');
                    } elseif (str_contains($routeName, 'admin.president')) {
                        $frontendUrl = route('president');
                    } elseif (str_contains($routeName, 'admin.deans')) {
                        // Check if editing a specific dean
                        if (request()->route('dean')) {
                            $deanOrder = request()->route('dean')->order;
                            $frontendUrl = route('dean' . $deanOrder);
                        } else {
                            $frontendUrl = route('dean1'); // Default to dean1
                        }
                    } elseif (str_contains($routeName, 'admin.external-protocols')) {
                        $frontendUrl = route('externalprotocols');
                    } elseif (str_contains($routeName, 'admin.internal-protocols')) {
                        $frontendUrl = route('internalprotocols');
                    } elseif (str_contains($routeName, 'admin.competitions')) {
                        $frontendUrl = route('competitions');
                    } elseif (str_contains($routeName, 'admin.graduates')) {
                        $frontendUrl = route('graduates');
                    } elseif (str_contains($routeName, 'admin.tuition-fees')) {
                        $frontendUrl = route('fees');
                    } elseif (str_contains($routeName, 'admin.dashboard')) {
                        $frontendUrl = route('home');
                    }
                @endphp
                
                <a href="{{ $frontendUrl }}" class="flex items-center gap-2 px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200 font-medium text-sm">
                    <i class="fas fa-external-link-alt"></i>
                    <span class="hidden sm:inline">View Website</span>
                </a>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="inline" onsubmit="return confirm('Are you sure you want to log out?');">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 font-medium text-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar Navigation -->
    <aside class="sidebar fixed top-0 left-0 h-full w-64 hidden md:block" style="background-color: #1a096e; width: 250px;">
        <div class="sidebar-header px-6 py-6 border-b border-white border-opacity-10">
            <h1 class="text-white text-xl font-bold tracking-tight">Admin Panel</h1>
        </div>
        <nav class="sidebar-nav" role="navigation" aria-label="Main navigation">
            <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.dashboard') ? 'page' : 'false' }}">
                <i class="fas fa-tachometer-alt mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.events.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.events.*') ? 'page' : 'false' }}">
                <i class="fas fa-calendar-alt mr-3"></i>
                <span>Events</span>
            </a>
            <a href="{{ route('admin.news.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.news.*') ? 'page' : 'false' }}">
                <i class="fas fa-newspaper mr-3"></i>
                <span>News</span>
            </a>
            <a href="{{ route('admin.departments.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.departments.*') ? 'page' : 'false' }}">
                <i class="fas fa-building mr-3"></i>
                <span>Departments</span>
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.gallery.*') ? 'page' : 'false' }}">
                <i class="fas fa-images mr-3"></i>
                <span>Gallery</span>
            </a>
            <a href="{{ route('admin.trainings.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.trainings.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.trainings.*') ? 'page' : 'false' }}">
                <i class="fas fa-chalkboard-teacher mr-3"></i>
                <span>Trainings</span>
            </a>
            <a href="{{ route('admin.activities.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.activities.*') ? 'page' : 'false' }}">
                <i class="fas fa-trophy mr-3"></i>
                <span>Activities</span>
            </a>
            <a href="{{ route('admin.president.edit') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.president.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.president.*') ? 'page' : 'false' }}">
                <i class="fas fa-user-tie mr-3"></i>
                <span>President Page</span>
            </a>
            <a href="{{ route('admin.deans.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.deans.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.deans.*') ? 'page' : 'false' }}">
                <i class="fas fa-users-cog mr-3"></i>
                <span>Deans</span>
            </a>
            <a href="{{ route('admin.external-protocols.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.external-protocols.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.external-protocols.*') ? 'page' : 'false' }}">
                <i class="fas fa-handshake mr-3"></i>
                <span>External Protocols</span>
            </a>
            <a href="{{ route('admin.internal-protocols.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.internal-protocols.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.internal-protocols.*') ? 'page' : 'false' }}">
                <i class="fas fa-file-contract mr-3"></i>
                <span>Internal Protocols</span>
            </a>
            <a href="{{ route('admin.competitions.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.competitions.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.competitions.*') ? 'page' : 'false' }}">
                <i class="fas fa-trophy mr-3"></i>
                <span>Competitions</span>
            </a>
            <a href="{{ route('admin.graduates.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.graduates.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.graduates.*') ? 'page' : 'false' }}">
                <i class="fas fa-graduation-cap mr-3"></i>
                <span>Graduates</span>
            </a>
            <a href="{{ route('admin.tuition-fees.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.tuition-fees.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.tuition-fees.*') ? 'page' : 'false' }}">
                <i class="fas fa-money-bill-wave mr-3"></i>
                <span>Tuition Fees</span>
            </a>

            <a href="{{ route('admin.testimonials.index') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.testimonials.*') ? 'page' : 'false' }}">
                <i class="fas fa-quote-left mr-3"></i>
                <span>Testimonials</span>
            </a>

            <a href="{{ route('admin.admissions.pending') }}" class="nav-item flex items-center px-6 py-3 text-white {{ request()->routeIs('admin.admissions.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.admissions.*') ? 'page' : 'false' }}">
                <i class="fas fa-user-graduate mr-3"></i>
                <span>Admissions</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="content-area ml-0 md:ml-[250px]">
        @yield('admin_content')
    </main>

    @stack('scripts')

    <!-- Admin Safety Layer -->
    <script src="{{ asset('js/admin-safety.js') }}"></script>

    <script>
        // Mobile sidebar toggle functionality
        function toggleSidebar(event) {
            event.stopPropagation();
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');

            // Prevent body scroll when sidebar is open
            if (sidebar.classList.contains('mobile-open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        function closeSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close sidebar on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const sidebar = document.querySelector('.sidebar');
                if (sidebar && sidebar.classList.contains('mobile-open')) {
                    closeSidebar();
                }
            }
        });
    </script>
</body>
</html>
