@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                @if($product->image)
                <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="max-height: 400px; object-fit: cover;">
                @else
                <div class="bg-light text-center py-5">
                    <i class="fas fa-image fa-3x text-secondary"></i>
                </div>
                @endif
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <span class="badge bg-secondary mb-3">{{ $product->category->name }}</span>
                    <h1 class="h2 mb-3">{{ $product->name }}</h1>
                    
                    <h3 class="text-primary mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                    
                    <div class="mb-4">
                        <h5>Deskripsi Produk</h5>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                            Stok: {{ $product->stock }}
                        </span>
                    </div>
                    
                    @auth
                        @if($product->stock > 0)
                        <form action="#" method="POST" class="mb-3">
                            @csrf
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <input type="number" 
                                           name="quantity" 
                                           class="form-control" 
                                           value="1" 
                                           min="1" 
                                           max="{{ $product->stock }}">
                                </div>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </form>
                        @else
                        <button class="btn btn-secondary w-100 mb-3" disabled>
                            <i class="fas fa-times-circle me-2"></i>Stok Habis
                        </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Login untuk Membeli
                        </a>
                    @endauth
                    
                    <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-arrow-left me-2"></i>Kembali Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="mt-5">
        <h3 class="h4 mb-4">Produk Terkait</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
            <div class="col-md-3 col-6">
                <div class="card h-100">
                    @if($related->image)
                    <img src="{{ asset($related->image) }}" class="card-img-top" alt="{{ $related->name }}" style="height: 150px; object-fit: cover;">
                    @else
                    <div class="bg-light text-center py-3">
                        <i class="fas fa-image fa-2x text-secondary"></i>
                    </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">{{ $related->name }}</h6>
                        <p class="text-primary fw-bold mb-2">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                        <a href="{{ route('products.show', $related) }}" class="btn btn-outline-primary btn-sm w-100">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection