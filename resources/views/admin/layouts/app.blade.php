<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - University CMS</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Admin CSS -->
    <style>
        :root {
            --primary: #06BBCC;
            --secondary: #6c757d;
            --success: #198754;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #0dcaf0;
            --light: #F0FBFC;
            --dark: #181d38;
            --orange: #D08301;
            --purple: #1a096e;
        }

        body {
            font-family: "Heebo", sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, var(--purple) 0%, #0a1435 100%);
            padding: 20px 0;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--orange);
            border-radius: 3px;
        }

        .sidebar-brand {
            padding: 0 20px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-brand h4 {
            color: var(--orange);
            font-weight: 700;
            margin: 10px 0 5px;
        }

        .sidebar-brand small {
            color: rgba(255,255,255,0.7);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(208, 131, 1, 0.2);
            color: var(--orange);
            border-left: 3px solid var(--orange);
        }

        .sidebar-menu a i {
            width: 25px;
            margin-right: 10px;
            font-size: 16px;
        }

        .main-content {
            margin-left: 260px;
            padding: 20px;
            min-height: 100vh;
        }

        .top-navbar {
            background: white;
            padding: 15px 25px;
            margin: -20px -20px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--orange);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .card-header {
            background: white;
            border-bottom: 2px solid var(--orange);
            font-weight: 600;
            color: var(--dark);
        }

        .btn-primary {
            background: var(--orange);
            border-color: var(--orange);
        }

        .btn-primary:hover {
            background: #b67301;
            border-color: #b67301;
        }

        .badge-role {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-super-admin {
            background: #dc3545;
            color: white;
        }

        .badge-content-editor {
            background: #0dcaf0;
            color: white;
        }

        .badge-faculty-admin {
            background: #198754;
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: block !important;
            }
        }

        .mobile-toggle {
            display: none;
            background: var(--orange);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .table {
            background: white;
        }

        .table thead th {
            background: var(--light);
            color: var(--dark);
            font-weight: 600;
            border-bottom: 2px solid var(--orange);
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-graduation-cap fa-2x text-warning"></i>
            <h4>CMS Admin</h4>
            <small>University Management</small>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Pages Management -->
            <li>
                <a href="{{ route('admin.pages.index') }}" class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Pages</span>
                </a>
            </li>

            <!-- Content Blocks -->
            <li>
                <a href="{{ route('admin.content-blocks.index') }}" class="{{ request()->routeIs('admin.content-blocks.*') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    <span>Content Blocks</span>
                </a>
            </li>

            <!-- Media Library -->
            <li>
                <a href="{{ route('admin.media.index') }}" class="{{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i>
                    <span>Media Library</span>
                </a>
            </li>

            <!-- Events -->
            <li>
                <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Events</span>
                </a>
            </li>

            <!-- News -->
            <li>
                <a href="{{ route('admin.news.index') }}" class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>News</span>
                </a>
            </li>

            <!-- Contact Submissions -->
            <li>
                <a href="{{ route('admin.contacts.index') }}" class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <span>Contact Submissions</span>
                </a>
            </li>

            @if(auth()->user()->role === 'super_admin')
            <!-- Users (Super Admin Only) -->
            <li>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>

            <!-- Audit Logs (Super Admin Only) -->
            <li>
                <a href="{{ route('admin.audit-logs.index') }}" class="{{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Audit Logs</span>
                </a>
            </li>
            @endif

            <!-- Revisions -->
            <li>
                <a href="{{ route('admin.revisions.index') }}" class="{{ request()->routeIs('admin.revisions.*') ? 'active' : '' }}">
                    <i class="fas fa-code-branch"></i>
                    <span>Revisions</span>
                </a>
            </li>

            <!-- Logout -->
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div>
                <button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0 d-inline-block">@yield('page-title', 'Dashboard')</h5>
            </div>
            
            <div class="user-info">
                <div>
                    <strong>{{ auth()->user()->name }}</strong>
                    <br>
                    <small class="badge badge-{{ auth()->user()->role === 'super_admin' ? 'super-admin' : (auth()->user()->role === 'content_editor' ? 'content-editor' : 'faculty-admin') }}">
                        {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                    </small>
                </div>
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('scripts')
</body>
</html>
