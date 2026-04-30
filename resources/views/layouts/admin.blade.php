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
            --admin-bg: #f8f9fa;
        }

        body {
            background-color: var(--admin-bg);
            font-family: 'Inter', sans-serif;
            margin: 0;
            display: flex;
        }

        /* Sidebar */
        .admin-sidebar {
            width: var(--admin-sidebar-width);
            height: 100vh;
            background: #1e293b;
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 24px;
            background: #0f172a; /* Darker background for header */
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header .brand-name {
            padding-top: 5px;
            font-weight: 600;
            font-size: 16px;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .sidebar-header .admin-label {
            background: var(--admin-primary);
            color: #fff;
            font-size: 10px;
            font-weight: 500;
            padding: 2px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
        }

        .menu-item {
            padding: 12px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(255,255,255,0.05);
            color: #fff;
        }

        .menu-item i {
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* Main Content */
        .admin-main {
            margin-left: var(--admin-sidebar-width);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
        }

        .topbar-left h1 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
            color: #334155;
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
        }

        .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #e2e8f0;
        }

        .admin-content {
            padding: 30px;
        }

        /* Utility */
        .btn-logout {
            background: none;
            border: none;
            color: #cbd5e1;
            cursor: pointer;
            padding: 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-logout:hover {
            color: #f87171;
        }

        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('Images/brand-logos/logo-symbol.png') }}" alt="Logo" style="height: 32px;">
            <h2>Brand</h2>
            <div style="display: flex; flex-direction: column; line-height: 1.2;">
                <span class="brand-name">Admin</span>
                <span class="admin-label">Portal</span>
            </div>
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
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @yield('scripts')
</body>
</html>