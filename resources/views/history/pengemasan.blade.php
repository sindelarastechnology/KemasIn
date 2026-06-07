@extends('layouts.app')

@section('title', 'Riwayat Pengemasan')

@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Riwayat Pengemasan</h4>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Operator</th>
                            <th>Produk</th>
                            <th>Kemasan</th>
                            <th>Jumlah Dikemas</th>
                            <th>Bahan Terpakai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($progres as $i => $pr)
                        <tr>
                            <td>{{ $progres->firstItem() + $i }}</td>
                            <td>{{ \Carbon\Carbon::parse($pr->waktu_diproses)->format('d/m/Y H:i') }}</td>
                            <td>{{ $pr->pengguna->nama_lengkap ?? '-' }}</td>
                            <td><strong>{{ $pr->pengemasan->produk->nama_produk ?? '-' }}</strong></td>
                            <td>{{ $pr->pengemasan->kemasan->nama_kemasan ?? '-' }}</td>
                            <td><strong>{{ number_format($pr->jumlah_dikemas, 0, ',', '.') }}</strong> unit</td>
                            <td>
                                @foreach($pr->pengemasan->pengemasanBahan ?? [] as $b)
                                    <span class="badge bg-info text-dark me-1">
                                        {{ $b->bahanBaku->nama_bahan ?? '-' }}:
                                        {{ number_format($b->jumlah_per_unit * $pr->jumlah_dikemas, 2) }}
                                        {{ $b->bahanBaku->satuan ?? '' }}
                                    </span>
                                @endforeach
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat pengemasan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($progres->hasPages())
        <div class="card-footer">{{ $progres->links() }}</div>
        @endif
    </div>
</div>
@endsection
