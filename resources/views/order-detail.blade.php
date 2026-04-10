@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 text-center">Detail Pesanan</h2>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center p-3">
                    <h5 class="mb-0">Order #{{ $order->id }}</h5>
                    <span class="badge bg-light text-primary">{{ date('d M Y, H:i', strtotime($order->created_at)) }}</span>
                </div>
                
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted fw-bold mb-3">Informasi Pelanggan</h6>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <p class="mb-1"><i class="fas fa-user text-primary me-2"></i> {{ $order->name }}</p>
                            <p class="mb-1"><i class="fas fa-envelope text-primary me-2"></i> {{ $order->email }}</p>
                            <p class="mb-1"><i class="fas fa-phone text-primary me-2"></i> {{ $order->phone }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-1"><i class="fas fa-map-marker-alt text-primary me-2"></i> <strong>Alamat Pengiriman:</strong></p>
                            <p class="text-muted">{{ $order->address }}</p>
                        </div>
                    </div>
                    
                    <h6 class="text-uppercase text-muted fw-bold mb-3 border-top pt-4">Daftar Item</h6>
                    <div class="bg-light rounded p-3 mb-4">
                        <ul class="list-unstyled mb-0">
                            @php
                                $items = explode('; ', $order->items);
                            @endphp
                            @foreach($items as $item)
                                @if(!empty($item))
                                    <li class="py-2 border-bottom d-flex align-items-center">
                                        <i class="fas fa-shoe-prints text-muted me-3"></i> {{ $item }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4 border-top pt-4">
                        <h5 class="mb-0">Total Pembayaran:</h5>
                        <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h4>
                    </div>
                </div>
                
                <div class="card-footer bg-white border-0 text-center py-3">
                    <a href="{{ route('riwayat') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
