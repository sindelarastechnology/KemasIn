@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Laporan</h4>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100 text-center p-4">
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <div class="bg-success bg-opacity-10 p-4 rounded-3 mb-3">
                    <i class="fas fa-boxes fa-3x text-success"></i>
                </div>
                <h5 class="fw-bold">Laporan Pengemasan</h5>
                <p class="text-muted small">Lihat dan export laporan data pengemasan berdasarkan periode</p>
                <a href="{{ route('laporan.pengemasan') }}" class="btn btn-success mt-2">
                    <i class="fas fa-eye"></i> Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100 text-center p-4">
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <div class="bg-primary bg-opacity-10 p-4 rounded-3 mb-3">
                    <i class="fas fa-flask fa-3x text-primary"></i>
                </div>
                <h5 class="fw-bold">Laporan Bahan Baku</h5>
                <p class="text-muted small">Riwayat mutasi stok dan pemakaian bahan baku</p>
                <a href="{{ route('laporan.bahanBaku') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-eye"></i> Lihat Laporan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
