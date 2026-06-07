@extends('layouts.app')

@section('title', 'Kemasan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">Data Kemasan</h4>
    <a href="{{ route('kemasan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Kemasan
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kemasan</th>
                        <th>Ukuran</th>
                        <th>Harga (Otomatis)</th>
                        <th>Komposisi Bahan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kemasan as $key => $k)
                    <tr>
                        <td>{{ $kemasan->firstItem() + $key }}</td>
                        <td><strong>{{ $k->nama_kemasan }}</strong></td>
                        <td>{{ $k->ukuran }}</td>
                        <td>Rp {{ number_format($k->harga_kemasan, 0, ',', '.') }}</td>
                        <td>
                            @forelse($k->bahan as $b)
                                <span class="badge bg-info text-dark me-1">{{ $b->bahanBaku->nama_bahan ?? '-' }}: {{ number_format($b->jumlah_per_unit, 2) }} {{ $b->bahanBaku->satuan ?? '' }}</span>
                            @empty
                                <span class="text-muted">Belum ada bahan</span>
                            @endforelse
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('kemasan.edit', $k->id_kemasan) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kemasan.destroy', $k->id_kemasan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus {{ $k->nama_kemasan }}?')">
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
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data kemasan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($kemasan->hasPages())
    <div class="card-footer">
        {{ $kemasan->links() }}
    </div>
    @endif
</div>
@endsection
