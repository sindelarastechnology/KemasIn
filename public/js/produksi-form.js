$(document).ready(function () {
    function updateBahanInfo(select) {
        const row = select.closest('.bahan-row');
        const selected = select.find(':selected');
        const stok = selected.data('stok');
        const satuan = selected.data('satuan');
        const info = row.find('.bahan-info');
        if (stok !== undefined) {
            info.html('Stok: <strong>' + Number(stok).toLocaleString('id-ID', {minimumFractionDigits: 2}) + '</strong> ' + satuan);
        } else {
            info.html('Pilih bahan untuk info stok');
        }
    }

    $(document).on('change', '.bahan-select', function () {
        updateBahanInfo($(this));
    });

    function getNewRow(index) {
        var template = window.bahanOptionTemplate;
        return `
            <div class="row mb-2 bahan-row">
                <div class="col-md-5">
                    <select name="bahan[${index}][id_bahan]" class="form-select bahan-select" required>
                        <option value="">-- Pilih Bahan --</option>
                        ${template}
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="bahan[${index}][jumlah_per_unit]" class="form-control bahan-jumlah" placeholder="Jumlah per unit" required min="0.01">
                </div>
                <div class="col-md-3">
                    <div class="form-control-plaintext bahan-info small text-muted" style="padding-top:7px;">Pilih bahan untuk info stok</div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger hapus-bahan"><i class="fas fa-times"></i></button>
                </div>
            </div>
        `;
    }

    $('#tambah-bahan').on('click', function () {
        const index = bahanIndex++;
        $('#bahan-container').append(getNewRow(index));
    });

    $(document).on('click', '.hapus-bahan', function () {
        $(this).closest('.bahan-row').remove();
    });

    $('.bahan-select').each(function () {
        updateBahanInfo($(this));
    });
});
