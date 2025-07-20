<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bubblemart') }} - Gift Delivery Service</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset('template-assets/css/bootstrap-icons.css') }}">

    <!-- Scripts and Styles -->
    @if(app()->environment('local') && file_exists(public_path('build/manifest.json')))
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @elseif(file_exists(public_path('build/assets/app-DbaZCfaT.css')))
        <!-- Production Assets -->
        <link rel="stylesheet" href="{{ asset('build/assets/app-DbaZCfaT.css') }}">
        <script src="{{ asset('build/assets/app-BDAque31.js') }}" defer></script>
    @else
        <!-- Fallback to CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    @endif
    
    <!-- Storage Helper Script -->
    <script>
        // Helper function to handle missing images
        function handleImageError(img) {
            if (img.src.includes('storage/')) {
                // If it's a storage image that failed, use fallback
                if (img.src.includes('products/')) {
                    img.src = '{{ asset("template-assets/img/ecommerce/image-6.jpg") }}';
                } else if (img.src.includes('avatars/')) {
                    img.src = '{{ asset("template-assets/img/avatars/1.jpg") }}';
                }
            }
        }
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                    <i class="fas fa-gift me-2"></i>{{ config('app.name', 'Bubblemart') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('categories.index') }}">
                                <i class="fas fa-th-large me-1"></i>Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customize.index') }}">
                                <i class="fas fa-magic me-1"></i>Customize Gift
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('track') }}">
                                <i class="fas fa-truck me-1"></i>Track Gift
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">
                                <i class="fas fa-envelope me-1"></i>Contact Us
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Cart Icon -->
                        <li class="nav-item me-3">
                            <a class="nav-link position-relative" href="#">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    0
                                </span>
                            </a>
                        </li>
                        
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-1"></i>{{ __('Sign In') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus me-1"></i>{{ __('Sign Up') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('wallet.index') }}">
                                        <i class="fas fa-wallet me-2"></i>My Wallet
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="fas fa-shopping-bag me-2"></i>My Orders
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-dark text-white py-5 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h5><i class="fas fa-gift me-2"></i>Bubblemart</h5>
                        <p class="text-muted">Delivering happiness to your loved ones with our curated selection of gifts from the best brands and stores.</p>
                    </div>
                    <div class="col-md-2">
                        <h6>Quick Links</h6>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a></li>
                            <li><a href="{{ route('categories.index') }}" class="text-muted text-decoration-none">Categories</a></li>
                            <li><a href="{{ route('customize.index') }}" class="text-muted text-decoration-none">Customize Gift</a></li>
                            <li><a href="{{ route('track') }}" class="text-muted text-decoration-none">Track Gift</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h6>Support</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-muted text-decoration-none">About Us</a></li>
                            <li><a href="#" class="text-muted text-decoration-none">FAQ</a></li>
                            <li><a href="#contact" class="text-muted text-decoration-none">Contact Info</a></li>
                            <li><a href="#" class="text-muted text-decoration-none">Terms & Privacy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h6>Follow Us</h6>
                        <div class="d-flex gap-3">
                            <a href="#" class="text-muted"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="text-center text-muted">
                    <small>&copy; {{ date('Y') }} Bubblemart. All rights reserved.</small>
                </div>
            </div>
        </footer>
    </div>

    <!-- Custom Alerts -->
    @include('partials.custom-alerts')
</body>
</html>
