@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Manajemen Produk</h5>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
                    <i class="fas fa-plus"></i> Tambah
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Brand</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $p)
                                <tr>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->brand }}</td>
                                    <td>{{ $p->stock }}</td>
                                    <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id }}"><i class="fas fa-edit"></i></button>
                                        <form action="{{ url('/admin/product/delete/'.$p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                            @csrf
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>


                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Pesanan Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($orders as $o)
                        <li class="list-group-item">
                            <strong>{{ $o->name }}</strong><br>
                            <small class="text-muted">{{ date('d M Y H:i', strtotime($o->created_at)) }}</small><br>
                            <span class="text-success fw-bold">Rp {{ number_format($o->total_price, 0, ',', '.') }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center">Belum ada pesanan.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modals -->
@foreach($products as $p)
<div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/admin/product/update/'.$p->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="name" class="form-control" value="{{ $p->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Brand</label>
                        <input type="text" name="brand" class="form-control" value="{{ $p->brand }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control">{{ $p->description }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Stok</label>
                            <input type="number" name="stock" class="form-control" value="{{ $p->stock }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Harga</label>
                            <input type="number" name="price" class="form-control" value="{{ $p->price }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Gambar Produk <span class="text-muted small">(Biarkan kosong untuk mempertahankan logo brand)</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if($p->image)
                            <div class="mt-2">
                                <img src="{{ url($p->image) }}" alt="Preview" style="max-height: 80px; border-radius: 8px;">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Create Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/admin/product/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Brand</label>
                        <input type="text" name="brand" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Stok</label>
                            <input type="number" name="stock" class="form-control" value="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Harga</label>
                            <input type="number" name="price" class="form-control" value="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Gambar Produk <span class="text-muted small">(Opsional, jika kosong akan pakai logo brand)</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
