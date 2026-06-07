@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold mb-0">Tambah Produk</h4>
        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('produk.store') }}" method="POST" data-loading>
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk') }}" required maxlength="100" placeholder="Masukkan nama produk">
                    @error('nama_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Stok Belum Dikemas</label>
                        <input type="number" name="stok_tersedia" class="form-control @error('stok_tersedia') is-invalid @enderror" value="{{ old('stok_tersedia', 0) }}" required min="0">
                        @error('stok_tersedia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stok Sudah Dikemas</label>
                        <input type="number" name="stok_sudah_dikemas" class="form-control @error('stok_sudah_dikemas') is-invalid @enderror" value="{{ old('stok_sudah_dikemas', 0) }}" min="0">
                        @error('stok_sudah_dikemas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stok Minimum</label>
                        <input type="number" name="stok_minimum" class="form-control @error('stok_minimum') is-invalid @enderror" value="{{ old('stok_minimum', 0) }}" required min="0">
                        @error('stok_minimum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label">Harga Produk (Rp)</label>
                        <input type="number" name="harga_produk" class="form-control @error('harga_produk') is-invalid @enderror" value="{{ old('harga_produk') }}" required min="0">
                        @error('harga_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="1" placeholder="Opsional">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <hr class="my-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
