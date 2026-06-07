@extends('layouts.app')

@section('title', 'Data Pengemasan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold mb-0">Data Pengemasan</h4>
        @if(auth()->user()->role == 'admin')
            <a href="{{ route('pengemasan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Target Pengemasan
            </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Kemasan</th>
                            <th>Tgl Pengemasan</th>
                            <th>Target</th>
                            <th>Hasil</th>
                            <th>Status</th>
                            <th>Operator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengemasan as $i => $p)
                        <tr>
                            <td>{{ $pengemasan->firstItem() + $i }}</td>
                            <td><strong>{{ $p->produk->nama_produk ?? '-' }}</strong></td>
                            <td>{{ $p->kemasan->nama_kemasan ?? '-' }} ({{ $p->kemasan->ukuran ?? '-' }})</td>
                            <td>{{ $p->tgl_pengemasan->format('d/m/Y') }}</td>
                            <td>{{ number_format($p->target_jumlah, 0, ',', '.') }}</td>
                            <td><strong>{{ number_format($p->hasil_pengemasan, 0, ',', '.') }}</strong></td>
                            <td>
                                @if($p->status == 'direncanakan')
                                    <span class="badge bg-secondary">Direncanakan</span>
                                @elseif($p->status == 'proses')
                                    <span class="badge bg-warning text-dark">Proses</span>
                                @elseif($p->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($p->status == 'dibatalkan')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @endif
                            </td>
                            <td>
                                @if($p->operatorDitugaskan->isNotEmpty())
                                    @foreach($p->operatorDitugaskan as $op)
                                        <span class="badge bg-info text-dark me-1">{{ $op->nama_lengkap }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">Semua operator</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('pengemasan.show', $p->id_pengemasan) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->role == 'admin' && $p->status != 'selesai' && $p->status != 'dibatalkan')
                                        <a href="{{ route('pengemasan.edit', $p->id_pengemasan) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">Belum ada data pengemasan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($pengemasan->hasPages())
        <div class="card-footer">
            {{ $pengemasan->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
