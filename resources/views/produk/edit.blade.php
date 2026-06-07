@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold mb-0">Edit Produk: {{ $produk->nama_produk }}</h4>
        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('produk.update', $produk->id_produk) }}" method="POST" data-loading>
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk', $produk->nama_produk) }}" required maxlength="100">
                    @error('nama_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Stok Belum Dikemas</label>
                        <input type="number" name="stok_tersedia" class="form-control @error('stok_tersedia') is-invalid @enderror" value="{{ old('stok_tersedia', $produk->stok_tersedia) }}" required min="0">
                        @error('stok_tersedia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stok Sudah Dikemas</label>
                        <input type="number" name="stok_sudah_dikemas" class="form-control @error('stok_sudah_dikemas') is-invalid @enderror" value="{{ old('stok_sudah_dikemas', $produk->stok_sudah_dikemas) }}" min="0">
                        @error('stok_sudah_dikemas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stok Minimum</label>
                        <input type="number" name="stok_minimum" class="form-control @error('stok_minimum') is-invalid @enderror" value="{{ old('stok_minimum', $produk->stok_minimum) }}" required min="0">
                        @error('stok_minimum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label">Harga Produk (Rp)</label>
                        <input type="number" name="harga_produk" class="form-control @error('harga_produk') is-invalid @enderror" value="{{ old('harga_produk', $produk->harga_produk) }}" required min="0">
                        @error('harga_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="1">{{ old('keterangan', $produk->keterangan) }}</textarea>
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
