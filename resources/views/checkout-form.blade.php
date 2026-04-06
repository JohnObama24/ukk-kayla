@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">🛒 CHECKOUT</h1>
    
    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="mb-4">Informasi Pengiriman</h4>
                    
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <form action="/checkout/process" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg" required placeholder="Masukkan nama lengkap">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg" required placeholder="email@contoh.com">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="tel" name="phone" class="form-control form-control-lg" placeholder="0812-3456-7890">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Alamat Pengiriman <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control form-control-lg" rows="4" required placeholder="Jl. Contoh No. 123, Kota, Kode Pos"></textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill py-3">
                                <i class="fas fa-check-circle me-2"></i>KONFIRMASI PESANAN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="mb-4">🛍️ Ringkasan Pesanan</h4>
                    
                    @foreach($cart as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong>{{ $item['name'] }}</strong>
                            <br>
                            <small class="text-muted">{{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</small>
                        </div>
                        <div class="fw-bold">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Biaya Pengiriman</span>
                        <span class="text-success">GRATIS</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong class="fs-5">TOTAL</strong>
                        <strong class="fs-4 text-primary">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection