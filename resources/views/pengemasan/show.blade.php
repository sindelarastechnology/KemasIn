@extends('layouts.app')

@section('title', 'Detail Pengemasan')

@section('styles')
<style>
.progress { height: 28px; border-radius: 14px; background: #e9ecef; }
.progress-bar { line-height: 28px; font-size: 13px; font-weight: 600; border-radius: 14px; }
.info-table tr th { width: 180px; color: #6c757d; font-weight: 500; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Detail Pengemasan</h4>
            <small class="text-muted">{{ $pengemasan->produk->nama_produk ?? 'Produk' }} &middot; {{ $pengemasan->kemasan->nama_kemasan ?? '-' }}</small>
        </div>
        <div>
            @if(auth()->user()->role == 'admin' && $pengemasan->status != 'selesai' && $pengemasan->status != 'dibatalkan')
                <a href="{{ route('pengemasan.edit', $pengemasan->id_pengemasan) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('pengemasan.batalkan', $pengemasan->id_pengemasan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan target ini?')">
                    @csrf
                    <button class="btn btn-danger"><i class="fas fa-times"></i> Batalkan</button>
                </form>
            @endif
            <a href="{{ route('pengemasan.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><i class="fas fa-info-circle me-1 text-primary"></i> Informasi Pengemasan</div>
                <div class="card-body">
                    <table class="table table-sm info-table mb-0">
                        <tr><th>Produk</th><td><strong>{{ $pengemasan->produk->nama_produk ?? '-' }}</strong></td></tr>
                        <tr><th>Kemasan</th><td>{{ $pengemasan->kemasan->nama_kemasan ?? '-' }} ({{ $pengemasan->kemasan->ukuran ?? '-' }})</td></tr>
                        <tr><th>Tanggal Pengemasan</th><td>{{ $pengemasan->tgl_pengemasan->format('d/m/Y') }}</td></tr>
                        <tr><th>Target</th><td>{{ number_format($pengemasan->target_jumlah, 0, ',', '.') }} unit</td></tr>
                        <tr><th>Hasil</th><td>{{ number_format($pengemasan->hasil_pengemasan, 0, ',', '.') }} unit</td></tr>
                        <tr><th>Expired Date</th><td>{{ $pengemasan->expired_date->format('d/m/Y') }}</td></tr>
                        <tr><th>Status</th>
                            <td>
                                @if($pengemasan->status == 'direncanakan')
                                    <span class="badge bg-secondary">Direncanakan</span>
                                @elseif($pengemasan->status == 'proses')
                                    <span class="badge bg-warning text-dark">Proses</span>
                                @elseif($pengemasan->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($pengemasan->status == 'dibatalkan')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @endif
                            </td>
                        </tr>
                        <tr><th>Operator Ditugaskan</th>
                            <td>
                                @if($pengemasan->operatorDitugaskan->isNotEmpty())
                                    @foreach($pengemasan->operatorDitugaskan as $op)
                                        <span class="badge bg-info text-dark me-1">{{ $op->nama_lengkap }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">Semua operator</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><i class="fas fa-chart-line me-1 text-primary"></i> Progress</div>
                <div class="card-body d-flex flex-column justify-content-center">
                    @php
                        $persen = $pengemasan->target_jumlah > 0 ? round(($pengemasan->hasil_pengemasan / $pengemasan->target_jumlah) * 100) : 0;
                        $sisa = $pengemasan->target_jumlah - $pengemasan->hasil_pengemasan;
                    @endphp
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated {{ $persen == 100 ? 'bg-success' : 'bg-primary' }}" style="width: {{ $persen }}%">
                            {{ $persen }}%
                        </div>
                    </div>
                    <div class="d-flex justify-content-between text-muted small mb-0">
                        <span>{{ number_format($pengemasan->hasil_pengemasan, 0, ',', '.') }} unit selesai</span>
                        <span>{{ number_format($pengemasan->target_jumlah, 0, ',', '.') }} unit target</span>
                    </div>
                    @if($sisa > 0)
                        <div class="text-center mt-2">
                            <span class="badge bg-light text-dark">Sisa: {{ number_format($sisa, 0, ',', '.') }} unit</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header"><i class="fas fa-flask me-1 text-primary"></i> Bahan Baku per Unit</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Bahan</th>
                            <th>Jumlah per Unit</th>
                            <th>Satuan</th>
                            <th>Total Terealisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengemasan->pengemasanBahan as $i => $b)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><strong>{{ $b->bahanBaku->nama_bahan }}</strong></td>
                            <td>{{ number_format($b->jumlah_per_unit, 2) }}</td>
                            <td>{{ $b->bahanBaku->satuan }}</td>
                            <td>{{ number_format($b->total_terealisasi, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-history me-1 text-primary"></i> Riwayat Progress</span>
            @if($pengemasan->status != 'selesai' && $pengemasan->status != 'dibatalkan' && auth()->user()->role != 'pemilik')
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahProgres">
                    <i class="fas fa-plus"></i> Tambah Progress
                </button>
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Jumlah Dikemas</th>
                            <th>Operator</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengemasan->progresPengemasan as $i => $pr)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $pr->waktu_diproses ? \Carbon\Carbon::parse($pr->waktu_diproses)->format('d/m/Y H:i') : '-' }}</td>
                            <td><strong>{{ number_format($pr->jumlah_dikemas, 0, ',', '.') }}</strong> unit</td>
                            <td>{{ $pr->pengguna->nama_lengkap ?? '-' }}</td>
                            <td>{{ $pr->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada progress</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if($pengemasan->status != 'selesai' && $pengemasan->status != 'dibatalkan' && auth()->user()->role != 'pemilik')
<div class="modal fade" id="modalTambahProgres" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('pengemasan.tambahProgres', $pengemasan->id_pengemasan) }}" method="POST" id="formTambahProgres">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Progress Pengemasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jumlah Dikemas (unit)</label>
                        <input type="number" name="jumlah_dikemas" class="form-control form-control-lg" required min="1" max="{{ max(0, $pengemasan->target_jumlah - $pengemasan->hasil_pengemasan) }}" placeholder="Masukkan jumlah">
                        <small class="text-muted">Sisa target: <strong>{{ number_format(max(0, $pengemasan->target_jumlah - $pengemasan->hasil_pengemasan), 0, ',', '.') }}</strong> unit</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan <small class="text-muted">(opsional)</small></label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                    </div>
                    <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                        <i class="fas fa-info-circle"></i>
                        <span>Bahan baku akan dikurangi dan stok produk akan bertambah sesuai jumlah yang dikemas.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-submit-loading">
                        <i class="fas fa-save me-1"></i> Simpan Progress
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
