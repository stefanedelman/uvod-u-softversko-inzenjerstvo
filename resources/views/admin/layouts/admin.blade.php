<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - SnowShop Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #212529;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 5px;
            margin: 2px 10px;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .sidebar .nav-link.active {
            background: #0d6efd;
            color: white;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .stat-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 px-0 sidebar">
                <div class="p-3 text-white">
                    <h4><i class="bi bi-snow"></i> SnowShop</h4>
                    <small class="text-muted">Admin Panel</small>
                </div>
                <hr class="text-secondary mx-3">
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products') }}">
                        <i class="bi bi-box-seam"></i> Proizvodi
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" href="{{ route('admin.categories') }}">
                        <i class="bi bi-tags"></i> Kategorije
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders') }}">
                        <i class="bi bi-cart-check"></i> Narudžbine
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                        <i class="bi bi-people"></i> Korisnici
                    </a>
                </nav>
                <hr class="text-secondary mx-3 mt-4">
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="bi bi-shop"></i> Nazad na Shop
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mx-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100 mt-2">
                            <i class="bi bi-box-arrow-right"></i> Odjavi se
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <!-- Top Bar -->
                <div class="bg-white shadow-sm p-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
                        <div>
                            <span class="text-muted">Ulogovan kao:</span>
                            <strong>{{ Auth::user()->name }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <div class="px-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
