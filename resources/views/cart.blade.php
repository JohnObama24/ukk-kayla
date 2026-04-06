@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">🛒 KERANJANG BELANJA</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(empty($cart))
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-shopping-cart fa-4x mb-3 text-muted"></i>
            <h3>Keranjang kamu kosong</h3>
            <p class="mb-4">Yuk mulai belanja sepatu impianmu!</p>
            <a href="/shop" class="btn btn-primary btn-lg">MULAI BELANJA</a>
        </div>
    @else
        <div class="row">
            <div class="col-md-8">
                @foreach($cart as $index => $item)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5>{{ $item['name'] }}</h5>
                                <p class="text-muted mb-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                            <div class="col-md-3">
                                <form action="/cart/update/{{ $index }}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="form-control me-2" style="width: 80px;">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">✓</button>
                                </form>
                            </div>
                            <div class="col-md-3 text-end">
                                <p class="fw-bold">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</p>
                                <a href="/cart/remove/{{ $index }}" class="btn btn-sm btn-danger" onclick="return confirm('Hapus dari keranjang?')">Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan Belanja</h5>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Item:</span>
                            <span class="fw-bold">{{ count($cart) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Harga:</span>
                            <span class="fw-bold text-primary fs-4">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <a href="/checkout" class="btn btn-success w-100 py-3 fw-bold">CHECKOUT SEKARANG</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection