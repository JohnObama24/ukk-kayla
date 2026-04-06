<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ShoeStore - E-Commerce Sepatu')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        /* BACKGROUND GRADIENT */
       body {
    background: url('/images/nav.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Segoe UI', sans-serif;
    min-height: 100vh;
    /* Efek parallax */
    background-attachment: fixed;
}
        
        /* Navbar styling */
        .navbar {
            box-shadow: 0 4px 12px hsla(56, 88%, 68%, 0.00);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        /* Card styling */
        .card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0,0,0,0.15) !important;
        }
        
        .card-img-top {
            height: 220px;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .card:hover .card-img-top {
            transform: scale(1.05);
        }
        
        .badge {
            font-weight: 500;
            padding: 0.5rem 1rem;
        }
        
        .btn-primary {
            border-radius: 2rem;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(13,110,253,0.3);
        }
        
        /* Footer styling */
        footer {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(0,0,0,0.05);
            margin-top: 3rem;
        }
        
        /* Cart badge */
        .cart-badge {
            position: relative;
            top: -8px;
            right: 5px;
            font-size: 0.7rem;
        }
        
        /* Animasi loading */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .container {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            <i class="fas fa-store me-2"></i>kyll & co
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item mx-2">
                    <a class="nav-link" href="/">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="/shop">
                        <i class="fas fa-shoe-prints me-1"></i>Shop
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link position-relative" href="/cart">
                        <i class="fas fa-shopping-cart fa-lg me-1"></i>Cart
                        @php
                            $cartCount = count(session('cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7rem;">
                                {{ $cartCount }}
                                <span class="visually-hidden">items in cart</span>
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <!-- Main Content -->
    <main class="py-5">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4">
        <div class="container text-center">
            <p class="mb-1">&copy; 2026 kyll & co. All rights reserved.</p>
            <small class="text-muted">Temukan sepatu impian Anda di sini</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Optional: tambah animasi sederhana -->
   <script>
    // Animasi badge keranjang
    document.addEventListener('DOMContentLoaded', function() {
        const cartBadge = document.querySelector('.badge.rounded-pill.bg-danger');
        if(cartBadge) {
            cartBadge.style.animation = 'bounce 0.5s';
        }
    });
    
    // Animasi bounce
    const style = document.createElement('style');
    style.textContent = `
        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
    `;
    document.head.appendChild(style);
</script>
</body>
</html>      