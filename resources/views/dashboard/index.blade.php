@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    .kpi-card.bg-kpi-primary { background: linear-gradient(135deg, #0d6efd, #0a58ca); color: #fff; }
    .kpi-card.bg-kpi-success { background: linear-gradient(135deg, #198754, #146c43); color: #fff; }
    .kpi-card.bg-kpi-warning { background: linear-gradient(135deg, #ffc107, #d39e00); color: #212529; }
    .kpi-card.bg-kpi-danger  { background: linear-gradient(135deg, #dc3545, #b02a37); color: #fff; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Dashboard</h3>
    <small class="text-muted">{{ now()->translatedFormat('l, d F Y') }}</small>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="kpi-card bg-kpi-primary shadow">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Stok Belum Dikemas</div>
                    <div class="kpi-value mt-1">{{ number_format($totalStokBelumDikemas) }}</div>
                    <div class="kpi-trend mt-2">
                        <i class="fas fa-cube me-1"></i> Total produk tersedia
                    </div>
                </div>
                <div class="kpi-icon bg-white bg-opacity-25">
                    <i class="fas fa-cube"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="kpi-card bg-kpi-success shadow">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Stok Sudah Dikemas</div>
                    <div class="kpi-value mt-1">{{ number_format($totalStokSudahDikemas) }}</div>
                    <div class="kpi-trend mt-2">
                        <i class="fas fa-box me-1"></i> Total produk jadi
                    </div>
                </div>
                <div class="kpi-icon bg-white bg-opacity-25">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="kpi-card bg-kpi-warning shadow">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Bahan Kritis</div>
                    <div class="kpi-value mt-1">{{ $bahanKritis }}</div>
                    <div class="kpi-trend mt-2">
                        <i class="fas fa-exclamation-triangle me-1"></i> Stok di bawah minimum
                    </div>
                </div>
                <div class="kpi-icon bg-dark bg-opacity-10">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="kpi-card bg-kpi-danger shadow">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Produk Hampir Habis</div>
                    <div class="kpi-value mt-1">{{ $produkBelumDikemasKritis }}</div>
                    <div class="kpi-trend mt-2">
                        <i class="fas fa-times-circle me-1"></i> Stok di bawah minimum
                    </div>
                </div>
                <div class="kpi-icon bg-white bg-opacity-25">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-bar me-1 text-primary"></i> Grafik Pengemasan 7 Hari</span>
                <span class="badge bg-primary">{{ array_sum($dataPengemasanGrafik) }} unit</span>
            </div>
            <div class="card-body">
                <canvas id="chartPengemasan" height="180"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-info-circle me-1 text-primary"></i> Ringkasan
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded-3">
                            <div class="text-muted small">Pengemasan Bulan Ini</div>
                            <div class="fs-3 fw-bold text-primary">{{ number_format($totalPengemasan) }}</div>
                            <div class="text-muted small">unit dikemas</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded-3">
                            <div class="text-muted small">Rata-rata Harian</div>
                            <div class="fs-3 fw-bold text-success">
                                {{ $totalPengemasan > 0 && now()->daysInMonth > 0 ? number_format($totalPengemasan / now()->day) : 0 }}
                            </div>
                            <div class="text-muted small">unit/hari</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-1 text-primary"></i> Pengemasan Terbaru</span>
        <a href="{{ route('pengemasan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kemasan</th>
                        <th>Tanggal</th>
                        <th>Target</th>
                        <th>Hasil</th>
                        <th>Status</th>
                        <th>Operator</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengemasanTerbaru as $p)
                    <tr>
                        <td><strong>{{ $p->produk->nama_produk ?? '-' }}</strong></td>
                        <td>{{ $p->kemasan->nama_kemasan ?? '-' }}</td>
                        <td>{{ $p->tgl_pengemasan->format('d/m/Y') }}</td>
                        <td>{{ number_format($p->target_jumlah) }}</td>
                        <td>{{ number_format($p->hasil_pengemasan) }}</td>
                        <td>
                            <span class="badge bg-{{ $p->status == 'selesai' ? 'success' : ($p->status == 'proses' ? 'warning' : ($p->status == 'dibatalkan' ? 'danger' : 'secondary')) }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>{{ $p->operatorDitugaskan->isNotEmpty() ? $p->operatorDitugaskan->pluck('nama_lengkap')->implode(', ') : 'Semua' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data pengemasan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
var ctx = document.getElementById('chartPengemasan').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($tanggal7Hari),
        datasets: [{
            label: 'Hasil Pengemasan',
            data: @json($dataPengemasanGrafik),
            backgroundColor: 'rgba(13, 110, 253, 0.7)',
            borderColor: 'rgba(13, 110, 253, 1)',
            borderWidth: 1,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,.05)' },
                ticks: { precision: 0 }
            },
            x: {
                grid: { display: false }
            }
        }
    }
});
</script>
@endsection
