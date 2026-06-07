@extends('layouts.app')

@section('title', 'Laporan Bahan Baku')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Laporan Bahan Baku</h4>
        <a href="{{ route('laporan.exportBahanBaku', request()->query()) }}" class="btn btn-success">
            <i class="fas fa-file-csv"></i> Export CSV
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ $tanggalAwal }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ $tanggalAkhir }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card bg-danger text-white h-100">
                <div class="card-body text-center">
                    <i class="fas fa-arrow-down mb-2"></i>
                    <div class="text-muted small text-white-50">Total Pemakaian</div>
                    <h2 class="mb-0">{{ number_format(abs($totalPemakaian), 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body text-center">
                    <i class="fas fa-arrow-up mb-2"></i>
                    <div class="text-muted small text-white-50">Total Penambahan</div>
                    <h2 class="mb-0">{{ number_format($totalPenambahan, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body text-center">
                    <i class="fas fa-exchange-alt mb-2"></i>
                    <div class="text-muted small text-white-50">Total Mutasi</div>
                    <h2 class="mb-0">{{ $totalMutasi }}</h2>
                </div>
            </div>
        </div>
    </div>

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
                            <th>Keterangan</th>
                            <th>Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mutasi as $i => $m)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($m->created_at)->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $m->bahan->nama_bahan ?? '-' }}</strong></td>
                            <td>
                                @switch($m->jenis)
                                    @case('pemakaian') <span class="badge bg-danger">Pemakaian</span> @break
                                    @case('penambahan') <span class="badge bg-success">Penambahan</span> @break
                                    @case('bahan_baru') <span class="badge bg-primary">Bahan Baru</span> @break
                                    @default <span class="badge bg-secondary">{{ $m->jenis }}</span>
                                @endswitch
                            </td>
                            <td class="text-end {{ $m->jumlah < 0 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                                {{ $m->jumlah > 0 ? '+' : '' }}{{ number_format($m->jumlah, 2) }}
                            </td>
                            <td class="text-end">{{ number_format($m->stok_sebelum, 2) }}</td>
                            <td class="text-end">{{ number_format($m->stok_sesudah, 2) }}</td>
                            <td>{{ $m->keterangan ?? '-' }}</td>
                            <td>{{ $m->pengguna->nama_lengkap ?? 'Sistem' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">Tidak ada data mutasi pada periode ini</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
