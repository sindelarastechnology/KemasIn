@extends('layouts.app')

@section('title', 'Master Produk')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold mb-0">Master Produk</h4>
        <a href="{{ route('produk.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Stok Belum Dikemas</th>
                            <th>Stok Sudah Dikemas</th>
                            <th>Stok Minimum</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produk as $i => $p)
                        <tr>
                            <td>{{ $produk->firstItem() + $i }}</td>
                            <td><strong>{{ $p->nama_produk }}</strong></td>
                            <td>{{ number_format($p->stok_tersedia, 0, ',', '.') }}</td>
                            <td>{{ number_format($p->stok_sudah_dikemas, 0, ',', '.') }}</td>
                            <td>{{ number_format($p->stok_minimum, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($p->harga_produk, 0, ',', '.') }}</td>
                            <td>
                                @if($p->stok_tersedia <= $p->stok_minimum)
                                    <span class="badge bg-danger">Kritis</span>
                                @else
                                    <span class="badge bg-success">Aman</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('produk.edit', $p->id_produk) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('produk.destroy', $p->id_produk) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus produk {{ $p->nama_produk }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data produk</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($produk->hasPages())
        <div class="card-footer">{{ $produk->links() }}</div>
        @endif
    </div>
</div>
@endsection
