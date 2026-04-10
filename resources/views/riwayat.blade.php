@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">📋 RIWAYAT PEMBELIAN</h1>
    
    <!-- Orders are provided by the controller -->
    @if($orders->isEmpty())
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
            <h4>Belum ada pesanan</h4>
            <p>Yuk mulai belanja sekarang!</p>
            <a href="/shop" class="btn btn-primary mt-2">Mulai Belanja</a>
        </div>
    @else
        <div class="row">
            @foreach($orders as $order)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-primary mb-2">ORDER #{{ $order->id }}</span>
                                <h5 class="mb-1">{{ $order->name }}</h5>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-envelope me-1"></i>{{ $order->email }}
                                </p>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ date('d M Y, H:i', strtotime($order->created_at)) }}
                                </p>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary fs-5">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </div>
                                <a href="/order/{{ $order->id }}" class="btn btn-sm btn-outline-primary mt-2">
                                    Detail <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection