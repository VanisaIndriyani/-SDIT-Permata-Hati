<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aplikasi Pengelolaan Nilai Raport - SDIT Permata Hati')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-green: #28a745;
            --primary-red: #dc3545;
            --light-green: #d4edda;
            --light-red: #f8d7da;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            z-index: 1030;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        
        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }
        
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            height: calc(100vh - 56px);
            width: 16.666667%;
            background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
            box-shadow: 3px 0 15px rgba(0,0,0,0.1);
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1020;
            transition: all 0.3s ease;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--primary-green);
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #218838;
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 56px;
            left: 0;
            width: 100%;
            height: calc(100vh - 56px);
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1019;
        }
        
        .sidebar-overlay.show {
            display: block;
        }
        
        .main-content {
            transition: margin-left 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 15px !important;
            }
            
            .navbar-brand img {
                height: 30px !important;
            }
            
            .navbar-brand {
                font-size: 0.9rem !important;
            }
            
            .table-responsive {
                font-size: 0.85rem;
            }
            
            .card {
                margin-bottom: 15px;
            }
            
            .btn-group {
                flex-wrap: wrap;
            }
            
            .btn-group .btn {
                margin-bottom: 5px;
            }
        }
        
        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
            
            h2 {
                font-size: 1.5rem !important;
            }
            
            .table {
                font-size: 0.8rem;
            }
            
            .table th,
            .table td {
                padding: 0.5rem !important;
            }
            
            .btn {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }
            
            .card-body {
                padding: 1rem !important;
            }
            
            .form-control,
            .form-select {
                font-size: 0.875rem;
            }
            
            .badge {
                font-size: 0.75rem;
            }
            
            .d-flex.gap-1 .btn {
                padding: 4px 6px;
                font-size: 0.75rem;
            }
        }
        
        .sidebar .nav-link {
            color: #495057;
            padding: 14px 20px;
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
            margin: 2px 8px;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(40, 167, 69, 0.1), transparent);
            transition: left 0.5s;
        }
        
        .sidebar .nav-link:hover::before {
            left: 100%;
        }
        
        .sidebar .nav-link:hover {
            background: linear-gradient(135deg, var(--light-green) 0%, #e8f5e9 100%);
            border-left-color: var(--primary-green);
            color: var(--primary-green);
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
        }
        
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--light-green) 0%, #d4edda 100%);
            border-left-color: var(--primary-green);
            color: var(--primary-green);
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
            transform: translateX(3px);
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1em;
            transition: transform 0.3s ease;
        }
        
        .sidebar .nav-link:hover i {
            transform: scale(1.2);
        }
        
        .sidebar .nav-link.active i {
            transform: scale(1.15);
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        
        .btn-primary {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }
        
        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        
        .btn-primary-custom {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }
        
        .btn-primary-custom:hover {
            background-color: #218838;
            border-color: #1e7e34;
            color: white;
        }
        
        .btn-danger {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
        }
        
        .text-primary-custom {
            color: var(--primary-green) !important;
        }
        
        .bg-primary-custom {
            background-color: var(--primary-green) !important;
        }
        
        .alert-success {
            background-color: var(--light-green);
            border-color: var(--primary-green);
            color: #155724;
        }
        
        .alert-danger {
            background-color: var(--light-red);
            border-color: var(--primary-red);
            color: #721c24;
        }
        
        .table thead {
            background-color: var(--primary-green);
            color: white;
        }
        
        .stat-card {
            border-left: 4px solid var(--primary-green);
        }
        
        .stat-card.danger {
            border-left-color: var(--primary-red);
        }
        
        /* Bootstrap Pagination Custom Styling */
        .pagination {
            margin-top: 1rem;
        }
        
        .pagination .page-link {
            color: var(--primary-green);
            border-color: #dee2e6;
        }
        
        .pagination .page-link:hover {
            color: white;
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo" height="40" class="me-2">
                SDIT Permata Hati
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-person-circle"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth

    <div class="container-fluid p-0" style="padding-top: 56px;">
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
        
        <div class="row g-0">
            @auth
            @if(in_array(Auth::user()->role, ['admin', 'guru', 'wali_kelas', 'kepsek']))
            <div class="col-md-2 sidebar p-0" id="sidebar">
                <nav class="nav flex-column mt-3 px-2">
                    @if(Auth::user()->role == 'admin')
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="bi bi-people"></i> Kelola User
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}" href="{{ route('admin.guru.index') }}">
                            <i class="bi bi-person-badge"></i> Kelola Guru
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}" href="{{ route('admin.kelas.index') }}">
                            <i class="bi bi-building"></i> Kelola Kelas
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.mapel.*') ? 'active' : '' }}" href="{{ route('admin.mapel.index') }}">
                            <i class="bi bi-book"></i> Kelola Mapel
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}" href="{{ route('admin.siswa.index') }}">
                            <i class="bi bi-person-badge"></i> Kelola Siswa
                        </a>
                    @elseif(Auth::user()->role == 'guru')
                        <a class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}" href="{{ route('guru.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('guru.mapel') ? 'active' : '' }}" href="{{ route('guru.mapel') }}">
                            <i class="bi bi-book"></i> Mata Pelajaran
                        </a>
                        <a class="nav-link {{ request()->routeIs('guru.nilai.*') ? 'active' : '' }}" href="{{ route('guru.nilai.index') }}">
                            <i class="bi bi-pencil-square"></i> Input Nilai
                        </a>
                        <a class="nav-link {{ request()->routeIs('guru.rekap') ? 'active' : '' }}" href="{{ route('guru.rekap') }}">
                            <i class="bi bi-table"></i> Rekap Nilai
                        </a>
                    @elseif(Auth::user()->role == 'wali_kelas')
                        <a class="nav-link {{ request()->routeIs('wali.dashboard') ? 'active' : '' }}" href="{{ route('wali.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('wali.rekap') ? 'active' : '' }}" href="{{ route('wali.rekap') }}">
                            <i class="bi bi-table"></i> Rekap Nilai
                        </a>
                        <a class="nav-link {{ request()->routeIs('wali.raport.*') ? 'active' : '' }}" href="{{ route('wali.raport.index') }}">
                            <i class="bi bi-file-earmark-text"></i> Raport
                        </a>
                        <a class="nav-link {{ request()->routeIs('wali.cetak') ? 'active' : '' }}" href="{{ route('wali.cetak') }}">
                            <i class="bi bi-printer"></i> Cetak / Ekspor
                        </a>
                    @elseif(Auth::user()->role == 'kepsek')
                        <a class="nav-link {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}" href="{{ route('kepsek.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('kepsek.monitoring') ? 'active' : '' }}" href="{{ route('kepsek.monitoring') }}">
                            <i class="bi bi-graph-up"></i> Monitoring Nilai
                        </a>
                        <a class="nav-link {{ request()->routeIs('kepsek.data-guru') ? 'active' : '' }}" href="{{ route('kepsek.data-guru') }}">
                            <i class="bi bi-people"></i> Data Guru
                        </a>
                        <a class="nav-link {{ request()->routeIs('kepsek.data-kelas') ? 'active' : '' }}" href="{{ route('kepsek.data-kelas') }}">
                            <i class="bi bi-building"></i> Data Kelas
                        </a>
                        <a class="nav-link {{ request()->routeIs('kepsek.laporan') ? 'active' : '' }}" href="{{ route('kepsek.laporan') }}">
                            <i class="bi bi-file-earmark-bar-graph"></i> Laporan
                        </a>
                    @endif
                </nav>
            </div>
            <div class="col-md-10 main-content" style="margin-left: 16.666667%; padding: 15px;">
                <!-- Mobile Menu Toggle Button -->
                <button class="btn btn-primary d-md-none" onclick="toggleSidebar()" style="position: fixed; top: 60px; left: 10px; z-index: 1021; border-radius: 50%; width: 40px; height: 40px; padding: 0;">
                    <i class="bi bi-list"></i>
                </button>
            @else
            <div class="col-12">
            @endif
            @else
            <div class="col-12">
            @endauth
                <main class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid var(--primary-green);">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                                <strong>{{ session('success') }}</strong>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> 
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js for graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Toggle sidebar for mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }
        }
        
        // Close sidebar when clicking on a link (mobile)
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
                
                // Add ripple effect
                const ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.6)';
                ripple.style.width = '0';
                ripple.style.height = '0';
                ripple.style.left = '50%';
                ripple.style.top = '50%';
                ripple.style.transform = 'translate(-50%, -50%)';
                ripple.style.animation = 'ripple 0.6s ease-out';
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    width: 200px;
                    height: 200px;
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
        
        // Auto-dismiss success alerts after 5 seconds
        const successAlerts = document.querySelectorAll('.alert-success');
        successAlerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    </script>
    
    @stack('scripts')
</body>
</html>

