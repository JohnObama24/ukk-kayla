@extends('layouts.app')

@section('content')
<div class="container py-4 py-md-5">

    <!-- HEADER -->
    <div class="text-center mb-4 mb-md-5">
        <h1 class="fw-bold mb-2" style="font-size: clamp(1.8rem, 4vw, 2.8rem);">
            👟 NEWS COLLECTION
        </h1>
        <p class="text-muted" style="font-size: clamp(0.9rem, 2.5vw, 1.2rem);">
            Temukan gaya terbaikmu dengan koleksi sepatu pilihan
        </p>
    </div>
    
    <!-- SEARCH & FILTER -->
    <div class="row mb-4 mb-md-5">
        <div class="col-12 col-lg-10 mx-auto">
            <form action="/shop" method="GET" class="d-flex flex-column flex-md-row gap-2">
                
                <!-- SEARCH -->
                <input type="text" 
                       name="search" 
                       class="form-control form-control-lg rounded-pill" 
                       placeholder="Cari produk... (Nike, Adidas, Converse)"
                       value="{{ request('search') }}">

                <!-- BRAND -->
                <select name="brand" class="form-select form-select-lg rounded-pill">
                    <option value="">Semua Brand</option>
                    @foreach($brands as $brand)
                    <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                        {{ $brand }}
                    </option>
                    @endforeach
                </select>

                <!-- BUTTON -->
                <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100 w-md-auto">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
            </form>
            
            <!-- RESET -->
            @if(request('search') || request('brand'))
            <div class="text-center mt-3">
                <a href="/shop" class="text-muted small">
                    <i class="fas fa-times-circle me-1"></i>Reset Filter
                </a>
            </div>
            @endif
        </div>
    </div>
    
    <!-- PRODUK -->
    <div class="row g-3 g-md-4">
        @forelse($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            
            <div class="card h-100 shadow-sm border-0 rounded-4 hover-card position-relative">
                
                <!-- BADGE BRAND -->
                <div class="position-absolute top-0 start-0 m-2" style="z-index: 2;">
                    <span class="badge bg-primary px-2 py-1 small rounded-pill">
                        <i class="fas fa-tag me-1"></i>{{ $product->brand }}
                    </span>
                </div>
                
                <!-- GAMBAR - AUTO DETEK ATAU UPLOAD -->
                @php
                    if ($product->image) {
                        $imagePath = url($product->image);
                    } else {
                        $brandImage = strtolower($product->brand);
                        $imagePath = "/images/{$brandImage}.jpg";
                    }
                @endphp
                
                <img src="{{ $imagePath }}" 
                     class="card-img-top rounded-top-4" 
                     alt="{{ $product->name }}"
                     style="height: 180px; object-fit: cover; width: 100%; background: #f8f9fa;"
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/500x500/eeeeee/333333?text={{ urlencode($product->brand) }}'">
                
                <div class="card-body d-flex flex-column p-3">
                    
                    <!-- NAMA PRODUK -->
                    <h6 class="fw-bold mb-2" style="min-height: 40px;">{{ $product->name }}</h6>
                    
                    <!-- INFO BERAT & WARNA -->
                    <div class="mb-2">
                        <span class="badge bg-light text-dark border small me-1">
                            <i class="fas fa-weight-hanging me-1"></i>{{ $product->weight }}g
                        </span>
                        <span class="badge bg-light text-dark border small">
                            <i class="fas fa-palette me-1"></i>
                            @php
                                $colors = json_decode($product->colors ?? '[]');
                                echo count($colors) . ' warna';
                            @endphp
                        </span>
                    </div>
                    
                    <!-- UKURAN -->
                    <div class="mb-2">
                        <div class="d-flex flex-wrap gap-1">
                            @php
                                $sizes = json_decode($product->sizes ?? '[]');
                                $limitedSizes = array_slice($sizes, 0, 3);
                            @endphp
                            @foreach($limitedSizes as $size)
                                <span class="badge bg-secondary bg-opacity-25 text-dark small px-2 py-1">{{ $size }}</span>
                            @endforeach
                            @if(count($sizes) > 3)
                                <span class="badge bg-secondary bg-opacity-25 text-dark small px-2 py-1">
                                    +{{ count($sizes)-3 }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- HARGA & STOK -->
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-primary">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="text-muted small">
                                <i class="fas fa-box me-1"></i>{{ $product->stock }}
                            </span>
                        </div>
                        
                        <!-- TOMBOL DETAIL -->
                        <a href="/product/{{ $product->id }}" 
                           class="btn btn-outline-primary btn-sm w-100 rounded-pill">
                            <i class="fas fa-eye me-1"></i>Detail
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center py-5">
                <i class="fas fa-search fa-2x fa-md-3x mb-3 d-block"></i>
                <h5>Produk tidak ditemukan</h5>
                <p class="small">Coba kata kunci lain atau <a href="/shop">reset filter</a></p>
            </div>
        </div>
        @endforelse
    </div>

</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.1) !important;
}
</style>
@endsection