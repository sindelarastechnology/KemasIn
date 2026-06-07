@extends('layouts.app')

@section('title', 'Edit Kemasan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">Edit Kemasan</h4>
    <a href="{{ route('kemasan.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('kemasan.update', $kemasan->id_kemasan) }}" method="POST" data-loading>
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Kemasan</label>
                    <input type="text" class="form-control @error('nama_kemasan') is-invalid @enderror" name="nama_kemasan" value="{{ old('nama_kemasan', $kemasan->nama_kemasan) }}" required>
                    @error('nama_kemasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ukuran</label>
                    <input type="text" class="form-control @error('ukuran') is-invalid @enderror" name="ukuran" value="{{ old('ukuran', $kemasan->ukuran) }}" required>
                    @error('ukuran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-3 mb-3">
                <label class="form-label">Harga Kemasan (Otomatis)</label>
                <div class="form-control bg-light" id="harga-preview" style="cursor:not-allowed; font-weight: 600; font-size: 1.1rem;">Rp {{ number_format($kemasan->harga_kemasan, 2) }}</div>
                <input type="hidden" name="harga_kemasan" id="harga_kemasan" value="{{ $kemasan->harga_kemasan }}">
                <small class="text-muted"><i class="fas fa-calculator me-1"></i>Harga dihitung otomatis dari total harga bahan baku yang digunakan.</small>
            </div>

            <hr>
            <h6 class="fw-bold mb-2"><i class="fas fa-flask me-1"></i>Komposisi Bahan Baku (per unit kemasan)</h6>
            <div id="bahan-container">
                @foreach($kemasan->bahan as $i => $b)
                <div class="row g-2 mb-2 bahan-row align-items-end">
                    <div class="col-md-5">
                        <select name="bahan[{{ $i }}][id_bahan]" class="form-select bahan-select" required>
                            <option value="">-- Pilih Bahan --</option>
                            @foreach($bahanBaku as $bb)
                                <option value="{{ $bb->id_bahan }}" data-harga="{{ $bb->harga_per_satuan }}" data-satuan="{{ $bb->satuan }}" {{ $b->id_bahan == $bb->id_bahan ? 'selected' : '' }}>{{ $bb->nama_bahan }} ({{ $bb->satuan }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" step="0.01" name="bahan[{{ $i }}][jumlah_per_unit]" class="form-control jumlah-per-unit" value="{{ $b->jumlah_per_unit }}" placeholder="Jml/unit" required min="0.01">
                    </div>
                    <div class="col-md-2">
                        <small class="form-text text-muted bahan-satuan">{{ $b->bahanBaku->satuan ?? '-' }}</small>
                    </div>
                    <div class="col-md-1">
                        @if($loop->index > 0)
                            <button type="button" class="btn btn-sm btn-danger hapus-bahan"><i class="fas fa-times"></i></button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-sm btn-outline-success mt-2" id="tambah-bahan">
                <i class="fas fa-plus"></i> Tambah Bahan
            </button>

            <hr class="my-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
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

let index = {{ count($kemasan->bahan) }};
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
