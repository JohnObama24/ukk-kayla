@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <img src="{{ asset('images/' . ($product->image ?? 'default.jpg')) }}" 
                     class="card-img-top" 
                     alt="{{ $product->name }}"
                     style="height: 450px; object-fit: cover;"
                     onerror="this.src='https://via.placeholder.com/500x500?text={{ $product->brand }}'">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4 p-4">
                <h1 class="display-5 fw-bold mb-3">{{ $product->name }}</h1>
                
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-primary px-3 py-2">
                        <i class="fas fa-tag me-1"></i>{{ $product->brand }}
                    </span>
                    <span class="badge bg-secondary px-3 py-2">
                        <i class="fas fa-weight-hanging me-1"></i>{{ $product->weight }}g
                    </span>
                    <span class="badge bg-info px-3 py-2">
                        <i class="fas fa-box me-1"></i>Stok {{ $product->stock }}
                    </span>
                </div>
                
                <hr>
                
                <div class="mb-4">
                    <h5>Deskripsi</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>
                
                <div class="row mb-4">
                    <div class="col-6">
                        <h5>Material</h5>
                        <p>{{ $product->material ?? '-' }}</p>
                    </div>
                    <div class="col-6">
                        <h5>Berat</h5>
                        <p>{{ $product->weight ?? '-' }} gram</p>
                    </div>
                </div>
                
                @php
                    $sizes = json_decode($product->sizes ?? '[]');
                    $colors = json_decode($product->colors ?? '[]');
                @endphp
                
                @if(!empty($sizes))
                <div class="mb-4">
                    <h5>Ukuran Tersedia</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($sizes as $size)
                            <span class="badge bg-light text-dark border p-3" style="font-size: 1rem;">{{ $size }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if(!empty($colors))
                <div class="mb-4">
                    <h5>Warna Tersedia</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($colors as $color)
                            <span class="badge p-3" style="background-color: {{ 
                                $color == 'Hitam' ? '#000' : 
                                ($color == 'Putih' ? '#fff' : 
                                ($color == 'Merah' ? '#dc3545' : 
                                ($color == 'Biru' ? '#0d6efd' : 
                                ($color == 'Abu-abu' ? '#6c757d' : '#6c757d')))) 
                            }}; color: {{ $color == 'Putih' ? '#000' : '#fff' }}; border: 1px solid #ccc;">
                                {{ $color }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <hr>
                
                <div class="mb-4">
                    <h2 class="text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
                </div>
                
                <!-- TOMBOL TAMBAH KE KERANJANG (INI YANG KAMU MINTA) -->
                <div class="d-flex gap-3">
                    <a href="/cart/add/{{ $product->id }}" class="btn btn-success btn-lg flex-grow-1 rounded-pill">
                        <i class="fas fa-cart-plus me-2"></i>TAMBAH KE KERANJANG
                    </a>
                    <a href="/cart" class="btn btn-outline-primary btn-lg rounded-pill">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
                
                <div class="mt-3 text-center">
                    <a href="/shop" class="btn btn-link">← Kembali ke Shop</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge {
        transition: transform 0.2s;
        cursor: pointer;
    }
    .badge:hover {
        transform: scale(1.05);
    }
    .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
        border: none;
        font-weight: bold;
        letter-spacing: 1px;
    }
    .btn-success:hover {
        background: linear-gradient(135deg, #218838, #1e7e34);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40,167,69,0.3);
    }
</style>
@endsection