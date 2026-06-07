@extends('layouts.app')

@section('title', 'Tambah Target Pengemasan')

@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Tambah Target Pengemasan</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pengemasan.store') }}" method="POST" data-loading>
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Produk</label>
                        <select name="id_produk" class="form-select @error('id_produk') is-invalid @enderror" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->id_produk }}" {{ old('id_produk') == $p->id_produk ? 'selected' : '' }}>
                                    {{ $p->nama_produk }} (stok: {{ number_format($p->stok_tersedia) }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kemasan</label>
                        <select name="id_kemasan" id="id_kemasan" class="form-select @error('id_kemasan') is-invalid @enderror" required>
                            <option value="">-- Pilih Kemasan --</option>
                            @foreach($kemasan as $k)
                                <option value="{{ $k->id_kemasan }}" {{ old('id_kemasan') == $k->id_kemasan ? 'selected' : '' }}>
                                    {{ $k->nama_kemasan }} ({{ $k->ukuran }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_kemasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div id="info-bahan" class="mt-3" style="display:none;">
                    <div class="card bg-light border-0">
                        <div class="card-body py-2 px-3">
                            <small class="text-muted"><i class="fas fa-flask me-1"></i>Komposisi bahan baku:</small>
                            <div id="bahan-list" class="mt-1"></div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Pengemasan</label>
                        <input type="date" name="tgl_pengemasan" class="form-control @error('tgl_pengemasan') is-invalid @enderror" value="{{ old('tgl_pengemasan', date('Y-m-d')) }}" required>
                        @error('tgl_pengemasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Target Jumlah (unit)</label>
                        <input type="number" name="target_jumlah" class="form-control @error('target_jumlah') is-invalid @enderror" value="{{ old('target_jumlah') }}" required min="1" placeholder="Masukkan jumlah target">
                        @error('target_jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Expired Date</label>
                        <input type="date" name="expired_date" class="form-control @error('expired_date') is-invalid @enderror" value="{{ old('expired_date') }}" required>
                        @error('expired_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Operator Ditugaskan</label>
                    <div class="border rounded-3 p-3 bg-light @error('id_operator_ditugaskan') border-danger @enderror">
                        @forelse($operator as $o)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="id_operator_ditugaskan[]" value="{{ $o->id_pengguna }}" id="op_{{ $o->id_pengguna }}"
                                {{ is_array(old('id_operator_ditugaskan')) && in_array($o->id_pengguna, old('id_operator_ditugaskan')) ? 'checked' : '' }}>
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
                    <i class="fas fa-save"></i> Simpan Target
                </button>
                <a href="{{ route('pengemasan.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$('#id_kemasan').change(function() {
    var id = $(this).val();
    if (id) {
        $.get('/ajax/kemasan-bahan/' + id, function(data) {
            var html = '';
            $.each(data.bahan, function(i, b) {
                html += '<span class="badge bg-info text-dark me-1 mb-1">' +
                    b.nama_bahan + ': ' + parseFloat(b.jumlah_per_unit).toFixed(2) + ' ' + b.satuan +
                    ' (stok: ' + b.stok_tersedia + ')</span>';
            });
            $('#bahan-list').html(html);
            $('#info-bahan').show();
        });
    } else {
        $('#info-bahan').hide();
    }
});
</script>
@endsection
