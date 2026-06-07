@extends('layouts.app')

@section('title', 'Edit Target Pengemasan')

@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Edit Target Pengemasan</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pengemasan.update', $pengemasan->id_pengemasan) }}" method="POST" data-loading>
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Produk</label>
                        <select name="id_produk" class="form-select @error('id_produk') is-invalid @enderror" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->id_produk }}" {{ old('id_produk', $pengemasan->id_produk) == $p->id_produk ? 'selected' : '' }}>
                                    {{ $p->nama_produk }} (stok: {{ number_format($p->stok_tersedia) }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kemasan</label>
                        <select name="id_kemasan" class="form-select @error('id_kemasan') is-invalid @enderror" required>
                            <option value="">-- Pilih Kemasan --</option>
                            @foreach($kemasan as $k)
                                <option value="{{ $k->id_kemasan }}" {{ old('id_kemasan', $pengemasan->id_kemasan) == $k->id_kemasan ? 'selected' : '' }}>
                                    {{ $k->nama_kemasan }} ({{ $k->ukuran }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_kemasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Pengemasan</label>
                        <input type="date" name="tgl_pengemasan" class="form-control @error('tgl_pengemasan') is-invalid @enderror" value="{{ old('tgl_pengemasan', $pengemasan->tgl_pengemasan->format('Y-m-d')) }}" required>
                        @error('tgl_pengemasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Target Jumlah (unit)</label>
                        <input type="number" name="target_jumlah" class="form-control @error('target_jumlah') is-invalid @enderror" value="{{ old('target_jumlah', $pengemasan->target_jumlah) }}" required min="1">
                        @error('target_jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Expired Date</label>
                        <input type="date" name="expired_date" class="form-control @error('expired_date') is-invalid @enderror" value="{{ old('expired_date', $pengemasan->expired_date->format('Y-m-d')) }}" required>
                        @error('expired_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Operator Ditugaskan</label>
                    <div class="border rounded-3 p-3 bg-light @error('id_operator_ditugaskan') border-danger @enderror">
                        @php $selectedOps = old('id_operator_ditugaskan', $pengemasan->operatorDitugaskan->pluck('id_pengguna')->toArray()); @endphp
                        @forelse($operator as $o)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="id_operator_ditugaskan[]" value="{{ $o->id_pengguna }}" id="op_{{ $o->id_pengguna }}"
                                {{ in_array($o->id_pengguna, $selectedOps) ? 'checked' : '' }}>
                            <label class="form-check-label" for="op_{{ $o->id_pengguna }}">{{ $o->nama_lengkap }}</label>
                        </div>
                        @empty
                            <small class="text-muted">Belum ada operator</small>
                        @endforelse
                        <small class="d-block text-muted mt-1"><i class="fas fa-info-circle me-1"></i>Kosongkan semua jika semua operator boleh mengerjakan.</small>
                    </div>
                    @error('id_operator_ditugaskan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @error('id_operator_ditugaskan.*')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <hr class="my-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('pengemasan.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
