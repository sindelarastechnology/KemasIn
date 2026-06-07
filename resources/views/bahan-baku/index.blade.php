@extends('layouts.app')

@section('title', 'Bahan Baku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">Bahan Baku</h4>
    <a href="{{ route('bahan-baku.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Bahan Baku
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bahan</th>
                        <th>Satuan</th>
                        <th>Stok Tersedia</th>
                        <th>Stok Minimum</th>
                        <th>Harga/Satuan</th>
                        <th>Status Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bahanBaku as $key => $bahan)
                    <tr>
                        <td>{{ $bahanBaku->firstItem() + $key }}</td>
                        <td><strong>{{ $bahan->nama_bahan }}</strong></td>
                        <td>{{ $bahan->satuan }}</td>
                        <td>{{ number_format($bahan->stok_tersedia, 2) }}</td>
                        <td>{{ number_format($bahan->stok_minimum, 2) }}</td>
                        <td>Rp {{ number_format($bahan->harga_per_satuan, 0, ',', '.') }}</td>
                        <td>
                            @if($bahan->stok_tersedia <= $bahan->stok_minimum)
                                <span class="badge bg-danger">Kritis</span>
                            @else
                                <span class="badge bg-success">Aman</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('bahan-baku.tambahStok', $bahan->id_bahan) }}" class="btn btn-sm btn-success" title="Tambah Stok">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                                <a href="{{ route('bahan-baku.edit', $bahan->id_bahan) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('bahan-baku.destroy', $bahan->id_bahan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus {{ $bahan->nama_bahan }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data bahan baku</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($bahanBaku->hasPages())
    <div class="card-footer border-top-0">
        {{ $bahanBaku->links() }}
    </div>
    @endif
</div>
@endsection
