@extends('layouts.app')

@section('title', 'Tambah Stok Bahan Baku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">Tambah Stok: {{ $bahan->nama_bahan }}</h4>
    <a href="{{ route('bahan-baku.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card bg-light border-0">
            <div class="card-body text-center py-3">
                <div class="text-muted small">Stok Saat Ini</div>
                <div class="fs-4 fw-bold {{ $bahan->stok_tersedia <= $bahan->stok_minimum ? 'text-danger' : 'text-success' }}">
                    {{ number_format($bahan->stok_tersedia, 2) }}
                </div>
                <div class="text-muted small">{{ $bahan->satuan }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light border-0">
            <div class="card-body text-center py-3">
                <div class="text-muted small">Stok Minimum</div>
                <div class="fs-4 fw-bold">{{ number_format($bahan->stok_minimum, 2) }}</div>
                <div class="text-muted small">{{ $bahan->satuan }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light border-0">
            <div class="card-body text-center py-3">
                <div class="text-muted small">Harga/Satuan</div>
                <div class="fs-4 fw-bold">Rp {{ number_format($bahan->harga_per_satuan, 0, ',', '.') }}</div>
                <div class="text-muted small">per {{ $bahan->satuan }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('bahan-baku.simpanTambahStok', $bahan->id_bahan) }}" method="POST" data-loading>
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Jumlah Tambahan <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="jumlah_tambah" class="form-control form-control-lg @error('jumlah_tambah') is-invalid @enderror" value="{{ old('jumlah_tambah') }}" required min="0.01" placeholder="Masukkan jumlah stok yang ditambah">
                    @error('jumlah_tambah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Stok akan bertambah sebesar jumlah ini.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Harga Per Satuan (baru)</label>
                    <input type="number" step="0.01" name="harga_per_satuan" class="form-control form-control-lg @error('harga_per_satuan') is-invalid @enderror" value="{{ old('harga_per_satuan', $bahan->harga_per_satuan) }}" min="0">
                    @error('harga_per_satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Kosongi jika harga tidak berubah.</small>
                </div>

                <div class="col-12">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="2" placeholder="Contoh: Restock bahan baku">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Simpan Tambahan Stok
            </button>
        </form>
    </div>
</div>
@endsection
