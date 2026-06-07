@extends('layouts.app')

@section('title', 'Tambah Kemasan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">Tambah Kemasan</h4>
    <a href="{{ route('kemasan.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('kemasan.store') }}" method="POST" data-loading>
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Kemasan</label>
                    <input type="text" class="form-control @error('nama_kemasan') is-invalid @enderror" name="nama_kemasan" value="{{ old('nama_kemasan') }}" required maxlength="100" placeholder="Contoh: Kemasan Premium">
                    @error('nama_kemasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ukuran</label>
                    <input type="text" class="form-control @error('ukuran') is-invalid @enderror" name="ukuran" value="{{ old('ukuran') }}" required placeholder="Contoh: 10x15cm, 500ml">
                    @error('ukuran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-3 mb-3">
                <label class="form-label">Harga Kemasan (Otomatis)</label>
                <div class="form-control bg-light" id="harga-preview" style="cursor:not-allowed; font-weight: 600; font-size: 1.1rem;">Rp 0</div>
                <input type="hidden" name="harga_kemasan" id="harga_kemasan" value="0">
                <small class="text-muted"><i class="fas fa-calculator me-1"></i>Harga dihitung otomatis dari total harga bahan baku yang digunakan.</small>
            </div>

            <hr>
            <h6 class="fw-bold mb-2"><i class="fas fa-flask me-1"></i>Komposisi Bahan Baku (per unit kemasan)</h6>
            <p class="text-muted small mb-3">Tentukan bahan baku yang dibutuhkan untuk 1 unit kemasan ini.</p>
            <div id="bahan-container">
                <div class="row g-2 mb-2 bahan-row align-items-end">
                    <div class="col-md-5">
                        <select name="bahan[0][id_bahan]" class="form-select bahan-select" required>
                            <option value="">-- Pilih Bahan --</option>
                            @foreach($bahanBaku as $b)
                                <option value="{{ $b->id_bahan }}" data-harga="{{ $b->harga_per_satuan }}" data-satuan="{{ $b->satuan }}">{{ $b->nama_bahan }} ({{ $b->satuan }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" step="0.01" name="bahan[0][jumlah_per_unit]" class="form-control jumlah-per-unit" placeholder="Jumlah per unit" required min="0.01">
                    </div>
                    <div class="col-md-2">
                        <small class="form-text text-muted bahan-satuan">satuan</small>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-success mt-2" id="tambah-bahan">
                <i class="fas fa-plus"></i> Tambah Bahan
            </button>

            <hr class="my-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function hitungHarga() {
    var total = 0;
    $('.bahan-row').each(function() {
        var select = $(this).find('.bahan-select option:selected');
        var harga = parseFloat(select.data('harga')) || 0;
        var qty = parseFloat($(this).find('.jumlah-per-unit').val()) || 0;
        total += harga * qty;
    });
    $('#harga-preview').text('Rp ' + total.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#harga_kemasan').val(total);
}

$(document).on('change', '.bahan-select', function() {
    var sat = $(this).find('option:selected').data('satuan') || '-';
    $(this).closest('.bahan-row').find('.bahan-satuan').text(sat);
    hitungHarga();
});

$(document).on('input', '.jumlah-per-unit', hitungHarga);

let index = 1;
$('#tambah-bahan').click(function() {
    var row = $('.bahan-row:first').clone();
    row.find('select, input').each(function() {
        var name = $(this).attr('name');
        $(this).attr('name', name.replace(/\[\d+\]/, '[' + index + ']'));
        $(this).val('');
    });
    row.find('.bahan-satuan').text('satuan');
    row.find('.col-md-1').html('<button type="button" class="btn btn-sm btn-danger hapus-bahan"><i class="fas fa-times"></i></button>');
    $('#bahan-container').append(row);
    index++;
    hitungHarga();
});

$(document).on('click', '.hapus-bahan', function() {
    $(this).closest('.bahan-row').remove();
    hitungHarga();
});
</script>
@endsection
