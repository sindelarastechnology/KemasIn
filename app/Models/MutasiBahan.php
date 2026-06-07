<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiBahan extends Model
{
    protected $table = 'tbl_mutasi_bahan';
    protected $primaryKey = 'id_mutasi';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_bahan',
        'jenis',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
        'harga_sebelum',
        'harga_sesudah',
        'keterangan',
        'id_pengguna',
        'created_at',
    ];

    public function bahan()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan', 'id_bahan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
