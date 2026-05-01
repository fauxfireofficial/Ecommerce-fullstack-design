<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Brand Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-pages.css') }}">
    <style>
        :root {
            --admin-sidebar-width: 260px;
            --admin-primary: #0d6efd;
            --admin-primary-dark: #0a58ca;
            --admin-bg: #f8f9fa;
            --dark-bg: #1e293b;
            --text-dark: #334155;
            --radius-lg: 12px;
            --radius-md: 8px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        }

        body {
            background-color: var(--admin-bg);
            font-family: 'Inter', sans-serif;
            margin: 0;
            display: flex;
            color: var(--text-dark);
        }

        /* Sidebar */
        .admin-sidebar {
            width: var(--admin-sidebar-width);
            height: 100vh;
            background: var(--dark-bg);
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 1001;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-header {
            padding: 20px 24px;
            background: #0f172a;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header h2 { font-size: 20px; font-weight: 700; margin: 0; }

        .sidebar-header .admin-label {
            background: var(--admin-primary);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .sidebar-menu {
            flex: 1;
            padding: 20px 12px;
            overflow-y: auto;
        }

        .menu-item {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: var(--radius-md);
            margin-bottom: 4px;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 14px;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .menu-item.active {
            background: var(--admin-primary);
        }

        .menu-item i { width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        /* Main Content */
        .admin-main {
            margin-left: var(--admin-sidebar-width);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        .admin-topbar {
            height: 70px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 900;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: var(--text-dark);
            cursor: pointer;
            padding: 5px;
        }

        .topbar-left h1 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: var(--text-dark);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            background: #f1f5f9;
            padding: 6px 12px;
            border-radius: 50px;
            transition: background 0.2s;
        }

        .user-profile:hover { background: #e2e8f0; }

        .user-profile img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-profile span {
            font-weight: 500;
            font-size: 14px;
            color: #475569;
        }

        .admin-content {
            padding: 30px;
            max-width: 1600px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        @media (max-width: 992px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.active { transform: translateX(0); }
            .admin-main { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .sidebar-overlay.active { display: block; }
            .admin-topbar { padding: 0 20px; }
            .admin-content { padding: 20px; }
        }

        @media (max-width: 576px) {
            .topbar-right span { display: none; }
        }

    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <img src="{{ asset('Images/brand-logos/logo-symbol.png') }}" alt="Logo" style="height: 32px;">
            <h2>Brand</h2>
            <span class="admin-label">Portal</span>
        </div>

        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fa-solid fa-box"></i> Manage Products
            </a>
            <a href="{{ route('admin.orders.index') }}" class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fa-solid fa-truck"></i> Orders List
            </a>
            <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Users Management
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-gear"></i> Settings
            </a>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Section -->
    <main class="admin-main">
        <header class="admin-topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="topbar-right">
                <div class="user-profile">
                    <span>{{ auth()->user()->name }}</span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0d6efd&color=fff" alt="User">
                </div>
            </div>
        </header>

        <div class="admin-content">
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #28a745;">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Sidebar Script -->
    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }

        @auth
            const user = {
                id: "{{ auth()->user()->id }}",
                name: "{{ auth()->user()->name }}",
                email: "{{ auth()->user()->email }}",
                avatar: "{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : '' }}",
                isLoggedIn: true,
                isAdmin: true
            };
            localStorage.setItem('user_session', JSON.stringify(user));
        @else
            if (localStorage.getItem('user_session')) {
                localStorage.removeItem('user_session');
            }
        @endauth
    </script>
    @yield('scripts')
</body>
</html>