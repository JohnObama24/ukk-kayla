@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4 text-center p-5">
                <div class="mb-4">
                    <span class="display-1 text-success">✅</span>
                </div>
                <h1 class="text-success mb-4">PESANAN BERHASIL!</h1>
                <p class="lead mb-4">Terima kasih telah berbelanja di <strong>kyll & co</strong>.</p>
                <p class="text-muted mb-4">Pesananmu akan segera diproses.</p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="/shop" class="btn btn-primary btn-lg rounded-pill px-5">
                        <i class="fas fa-shopping-bag me-2"></i>BELANJA LAGI
                    </a>
                    <a href="/" class="btn btn-outline-secondary btn-lg rounded-pill px-5">
                        <i class="fas fa-home me-2"></i>HOME
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection