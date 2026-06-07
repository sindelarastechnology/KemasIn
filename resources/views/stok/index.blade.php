@extends('layouts.app')

@section('title', 'Stok Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Stok Produk</h4>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-cube me-1 text-primary"></i> Produk Belum Dikemas
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Stok Tersedia</th>
                                <th>Stok Minimum</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produk as $key => $p)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><strong>{{ $p->nama_produk }}</strong></td>
                                <td>{{ number_format($p->stok_tersedia) }}</td>
                                <td>{{ number_format($p->stok_minimum) }}</td>
                                <td>
                                    @if($p->stok_tersedia <= $p->stok_minimum)
                                        <span class="badge bg-danger">Kritis</span>
                                    @else
                                        <span class="badge bg-success">Aman</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada data produk</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-box me-1 text-success"></i> Produk Sudah Dikemas
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Stok Dikemas</th>
                                <th>Stok Minimum</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produk as $key => $p)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><strong>{{ $p->nama_produk }}</strong></td>
                                <td>{{ number_format($p->stok_sudah_dikemas) }}</td>
                                <td>{{ number_format($p->stok_minimum) }}</td>
                                <td>
                                    @if($p->stok_sudah_dikemas <= $p->stok_minimum)
                                        <span class="badge bg-warning text-dark">Sedikit</span>
                                    @else
                                        <span class="badge bg-success">Aman</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada data produk</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
