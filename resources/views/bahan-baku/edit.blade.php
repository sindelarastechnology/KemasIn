@extends('layouts.app')

@section('title', 'Edit Bahan Baku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">Edit Bahan Baku</h4>
    <a href="{{ route('bahan-baku.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('bahan-baku.update', $bahanBaku->id_bahan) }}" method="POST" data-loading>
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama_bahan" class="form-label">Nama Bahan</label>
                    <input type="text" class="form-control @error('nama_bahan') is-invalid @enderror" id="nama_bahan" name="nama_bahan" value="{{ old('nama_bahan', $bahanBaku->nama_bahan) }}" required>
                    @error('nama_bahan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="satuan" class="form-label">Satuan</label>
                    <select class="form-select @error('satuan') is-invalid @enderror" id="satuan" name="satuan" required>
                        <option value="">-- Pilih Satuan --</option>
                        <option value="kg" {{ old('satuan', $bahanBaku->satuan) == 'kg' ? 'selected' : '' }}>Kg</option>
                        <option value="liter" {{ old('satuan', $bahanBaku->satuan) == 'liter' ? 'selected' : '' }}>Liter</option>
                        <option value="lembar" {{ old('satuan', $bahanBaku->satuan) == 'lembar' ? 'selected' : '' }}>Lembar</option>
                        <option value="pcs" {{ old('satuan', $bahanBaku->satuan) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                        <option value="gram" {{ old('satuan', $bahanBaku->satuan) == 'gram' ? 'selected' : '' }}>Gram</option>
                    </select>
                    @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label for="stok_tersedia" class="form-label">Stok Tersedia</label>
                    <input type="number" step="0.01" class="form-control @error('stok_tersedia') is-invalid @enderror" id="stok_tersedia" name="stok_tersedia" value="{{ old('stok_tersedia', $bahanBaku->stok_tersedia) }}" min="0">
                    @error('stok_tersedia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label for="stok_minimum" class="form-label">Stok Minimum</label>
                    <input type="number" step="0.01" class="form-control @error('stok_minimum') is-invalid @enderror" id="stok_minimum" name="stok_minimum" value="{{ old('stok_minimum', $bahanBaku->stok_minimum) }}" required min="0">
                    @error('stok_minimum') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label for="harga_per_satuan" class="form-label">Harga Per Satuan (Rp)</label>
                    <input type="number" step="0.01" class="form-control @error('harga_per_satuan') is-invalid @enderror" id="harga_per_satuan" name="harga_per_satuan" value="{{ old('harga_per_satuan', $bahanBaku->harga_per_satuan) }}" required min="0">
                    @error('harga_per_satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $bahanBaku->keterangan) }}</textarea>
                    @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
        </form>
    </div>
</div>
@endsection
