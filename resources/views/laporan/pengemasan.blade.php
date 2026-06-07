@extends('layouts.app')

@section('title', 'Laporan Pengemasan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Laporan Pengemasan</h4>
        <div class="btn-group">
            <a href="{{ route('laporan.exportPengemasan', request()->query()) }}" class="btn btn-success">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
            <a href="{{ route('laporan.pdfPengemasan', request()->query()) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
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

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-1 text-primary"></i> Data Pengemasan</span>
            <span class="badge bg-primary">{{ $totalBatch }} batch</span>
        </div>
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
                            <th>Expired Date</th>
                            <th>Operator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengemasan as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><strong>{{ $p->produk->nama_produk ?? '-' }}</strong></td>
                            <td>{{ $p->kemasan->nama_kemasan ?? '-' }} ({{ $p->kemasan->ukuran ?? '-' }})</td>
                            <td>{{ $p->tgl_pengemasan->format('d/m/Y') }}</td>
                            <td class="text-end">{{ number_format($p->target_jumlah, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($p->hasil_pengemasan, 0, ',', '.') }}</td>
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
                            <td>{{ $p->expired_date->format('d/m/Y') }}</td>
                            <td>
                                @if($p->operatorDitugaskan->isNotEmpty())
                                    @foreach($p->operatorDitugaskan as $op)
                                        <span class="badge bg-info text-dark me-1">{{ $op->nama_lengkap }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">Semua operator</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-4"><strong>Total Batch:</strong> {{ $totalBatch }}</div>
                <div class="col-md-4"><strong>Total Target:</strong> {{ number_format($totalTarget, 0, ',', '.') }} unit</div>
                <div class="col-md-4"><strong>Total Hasil:</strong> {{ number_format($totalHasil, 0, ',', '.') }} unit</div>
            </div>
        </div>
    </div>
</div>
@endsection
