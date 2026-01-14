<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SnowShop') - Snowboard Oprema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }
        .product-card {
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .category-card {
            cursor: pointer;
            transition: all 0.3s;
        }
        .category-card:hover {
            background-color: #f8f9fa;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-snow"></i> SnowShop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Početna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/katalog') }}">Katalog</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/korpa') }}">
                            <i class="bi bi-cart"></i> Korpa
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="badge bg-danger">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->is_admin)
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Admin Panel</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Odjavi se</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Prijava</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registracija</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="bi bi-snow"></i> SnowShop</h5>
                    <p>Vaša destinacija za premium snowboard opremu.</p>
                </div>
                <div class="col-md-4">
                    <h5>Brzi linkovi</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/katalog') }}" class="text-white">Katalog</a></li>
                        <li><a href="{{ url('/korpa') }}" class="text-white">Korpa</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Kontakt</h5>
                    <p><i class="bi bi-envelope"></i> info@snowshop.rs</p>
                    <p><i class="bi bi-phone"></i> +381 11 123 4567</p>
                </div>
            </div>
            <hr>
            <p class="text-center mb-0">&copy; 2026 SnowShop. Sva prava zadržana.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
