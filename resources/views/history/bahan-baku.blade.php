@extends('layouts.app')

@section('title', 'Riwayat Bahan Baku')

@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Riwayat Bahan Baku</h4>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Bahan</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Stok Sebelum</th>
                            <th>Stok Sesudah</th>
                            <th>Harga Berubah</th>
                            <th>Keterangan</th>
                            <th>Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mutasi as $i => $m)
                        <tr>
                            <td>{{ $mutasi->firstItem() + $i }}</td>
                            <td>{{ \Carbon\Carbon::parse($m->created_at)->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $m->bahan->nama_bahan ?? '-' }}</strong></td>
                            <td>
                                @switch($m->jenis)
                                    @case('pemakaian')
                                        <span class="badge bg-danger">Pemakaian</span>
                                        @break
                                    @case('penambahan')
                                        <span class="badge bg-success">Penambahan Stok</span>
                                        @break
                                    @case('bahan_baru')
                                        <span class="badge bg-primary">Bahan Baru</span>
                                        @break
                                    @case('penyesuaian')
                                        <span class="badge bg-warning text-dark">Penyesuaian</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $m->jenis }}</span>
                                @endswitch
                            </td>
                            <td class="text-end {{ $m->jumlah < 0 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                                {{ $m->jumlah > 0 ? '+' : '' }}{{ number_format($m->jumlah, 2) }}
                            </td>
                            <td class="text-end">{{ number_format($m->stok_sebelum, 2) }}</td>
                            <td class="text-end">{{ number_format($m->stok_sesudah, 2) }}</td>
                            <td>
                                @if($m->harga_sebelum && $m->harga_sesudah && $m->harga_sebelum != $m->harga_sesudah)
                                    Rp {{ number_format($m->harga_sebelum, 2) }} → Rp {{ number_format($m->harga_sesudah, 2) }}
                                @elseif($m->jenis === 'bahan_baru' && $m->harga_sesudah)
                                    Rp {{ number_format($m->harga_sesudah, 2) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $m->keterangan ?? '-' }}</td>
                            <td>{{ $m->pengguna->nama_lengkap ?? 'Sistem' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">Belum ada riwayat bahan baku</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($mutasi->hasPages())
        <div class="card-footer">{{ $mutasi->links() }}</div>
        @endif
    </div>
</div>
@endsection
