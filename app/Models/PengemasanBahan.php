<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengemasanBahan extends Model
{
    protected $table = 'tbl_pengemasan_bahan';
    protected $primaryKey = 'id_pengemasan_bahan';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_pengemasan',
        'id_bahan',
        'jumlah_per_unit',
        'total_terealisasi',
    ];

    public function pengemasan()
    {
        return $this->belongsTo(Pengemasan::class, 'id_pengemasan', 'id_pengemasan');
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan', 'id_bahan');
    }
}
