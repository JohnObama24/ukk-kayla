@extends('layouts.app')

@section('title', 'Welcome to kyll & co')

@section('content')
<div class="row align-items-center min-vh-75 py-5">
    <div class="col-12 col-md-6 text-center text-md-start mb-5 mb-md-0">
        <h1 class="display-4 fw-bold text-dark mb-3">Selamat Datang di <span class="text-primary">kyll & co</span></h1>
        <p class="lead text-muted mb-4">Temukan berbagai koleksi sepatu terbaik dengan harga terjangkau. Kualitas dan kenyamanan adalah prioritas kami.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg px-4 me-md-2">Belanja Sekarang</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4">Daftar Akun</a>
            @endguest
        </div>
    </div>
    <div class="col-12 col-md-6 text-center">
        <!-- Menggunakan d-block mx-auto w-100 img-fluid untuk responsif pada mobile -->
        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8c2hvZXN8ZW58MHx8fHwxNjIzMTc5MDM4&ixlib=rb-1.2.1&q=80&w=600" class="img-fluid rounded-4 shadow-lg w-100" style="max-width: 500px; object-fit: cover;" alt="Sepatu Keren">
    </div>
</div>

<div class="row mt-5 pt-5 text-center">
    <div class="col-12 mb-4">
        <h2 class="fw-bold">Kenapa Memilih Kami?</h2>
    </div>
    <div class="col-12 col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm p-4">
            <i class="fas fa-shipping-fast text-primary fa-3x mb-3"></i>
            <h4>Pengiriman Cepat</h4>
            <p class="text-muted">Pesanan Anda akan dikirimkan di hari yang sama dengan keamanan terjamin.</p>
        </div>
    </div>
    <div class="col-12 col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm p-4">
            <i class="fas fa-medal text-primary fa-3x mb-3"></i>
            <h4>Kualitas Original</h4>
            <p class="text-muted">Semua produk yang kami jual 100% original dengan garansi uang kembali.</p>
        </div>
    </div>
    <div class="col-12 col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm p-4">
            <i class="fas fa-headset text-primary fa-3x mb-3"></i>
            <h4>Layanan 24/7</h4>
            <p class="text-muted">Tim support kami siap membantu Anda kapanpun Anda butuhkan.</p>
        </div>
    </div>
</div>
@endsection
