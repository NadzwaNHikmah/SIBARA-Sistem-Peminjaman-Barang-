<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Peminjaman Barang' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --background: #f8fafc;
            --surface: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --sidebar-width: 260px;
            --sidebar-collapsed: 80px;
            --header-height: 80px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            overflow-x: hidden;
            color: var(--text-primary);
        }

        /* === SIDEBAR === */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 100%);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            overflow-x: hidden;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        /* === BRAND SECTION === */
        .brand {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .brand-content {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
        }

        .logo-container {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .logo-container img {
            width: 44px;
            height: 44px;
            object-fit: contain;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            transition: opacity 0.3s ease;
        }

        .brand-name {
            font-weight: 700;
            font-size: 18px;
            color: white;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 400;
        }

        .sidebar.collapsed .brand-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
        }

        .sidebar.collapsed .brand {
            padding: 0;
            justify-content: center;
        }

        .sidebar.collapsed .logo-container {
            width: 36px;
            height: 36px;
        }

        /* === NAVIGATION MENU === */
        .sidebar-nav {
            padding: 24px 0;
            height: calc(100vh - var(--header-height) - 100px);
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }

        .nav-item {
            margin-bottom: 8px;
            padding: 0 16px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 16px;
            color: rgba(255, 255, 255, 0.8);
            padding: 14px 16px;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -16px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: white;
            border-radius: 0 2px 2px 0;
        }

        .nav-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .nav-link:hover .nav-icon {
            transform: scale(1.1);
        }

        .nav-text {
            transition: opacity 0.3s ease, visibility 0.3s ease;
            white-space: nowrap;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 14px 0;
        }

        /* === LOGOUT SECTION === */
        .logout-section {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed .btn-logout span {
            display: none;
        }

        /* === MAIN CONTENT === */
        .content {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            background: var(--background);
        }

        .sidebar.collapsed ~ .content {
            margin-left: var(--sidebar-collapsed);
        }

        /* === HEADER TOGGLE === */
        .header {
            position: sticky;
            top: 0;
            background: var(--surface);
            border-bottom: 1px solid #e2e8f0;
            padding: 0 30px;
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 900;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .toggle-btn {
            background: var(--surface);
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--text-primary);
            font-size: 18px;
        }

        .toggle-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* === MAIN CONTENT AREA === */
        .main-content {
            padding: 30px;
            min-height: calc(100vh - var(--header-height) - 80px);
        }

        /* === FOOTER === */
        footer {
            background: var(--surface);
            border-top: 1px solid #e2e8f0;
            padding: 20px 30px;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--text-secondary);
        }

        .sidebar.collapsed ~ footer {
            margin-left: var(--sidebar-collapsed);
        }

        /* === RESPONSIVE DESIGN === */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .content, footer {
                margin-left: 0 !important;
            }
            
            .header {
                padding: 0 20px;
            }
            
            .main-content {
                padding: 20px;
            }
            
            .toggle-btn {
                position: fixed;
                top: 18px;
                left: 20px;
                z-index: 1100;
                background: var(--primary);
                color: white;
                border: none;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 16px;
            }
            
            .header {
                padding: 0 16px;
            }
        }

        /* === ANIMATIONS === */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-content">
                <div class="logo-container">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo Sistem">
                </div>
                <div class="brand-text">
                    <div class="brand-name">SIBARA</div>
                    <div class="brand-subtitle">Sistem Peminjaman Barang</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link active">
                    <div class="nav-icon">🏠</div>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('barang.index') }}" class="nav-link">
                    <div class="nav-icon">📦</div>
                    <span class="nav-text">Barang</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('instansi.index') }}" class="nav-link">
                    <div class="nav-icon">🏢</div>
                    <span class="nav-text">Instansi</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('transaksi.index') }}" class="nav-link">
                    <div class="nav-icon">🔄</div>
                    <span class="nav-text">Transaksi</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                    <div class="nav-icon">👤</div>
                    <span class="nav-text">User</span>
                </a>
            </div>
        </nav>

        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Header --}}
    <div class="header">
        <button class="toggle-btn" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="d-none d-md-block">
                <div class="fw-semibold">{{ Auth::user()->name ?? 'Administrator' }}</div>
                <small class="text-muted">Admin</small>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="content">
        <main class="main-content fade-in">
            @yield('content')
        </main>
    </div>

    {{-- Footer --}}
    <footer>
        <div class="text-center">
            <small>© {{ date('Y') }} Sistem Informasi Peminjaman Barang - All rights reserved</small>
        </div>
    </footer>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        // Toggle sidebar
        toggleBtn.addEventListener('click', () => {
            if (window.innerWidth > 992) {
                sidebar.classList.toggle('collapsed');
            } else {
                sidebar.classList.toggle('active');
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 992 && 
                !sidebar.contains(e.target) && 
                !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('active');
            }
        });

        // Handle active nav links
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const currentUrl = window.location.href;
            
            navLinks.forEach(link => {
                if (currentUrl.startsWith(link.href)) {
                    navLinks.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                }
            });
        });

        // Smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => {
                    el.style.transition = 'opacity 0.5s ease';
                    el.style.opacity = '1';
                }, 100);
            });
        });
    </script>

</body>
</html>