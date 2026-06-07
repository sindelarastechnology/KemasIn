<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokProduk extends Model
{
    protected $table = 'tbl_stok_produk';
    protected $primaryKey = 'id_stok';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_kemasan',
        'jenis_produk',
        'stok_tersedia',
        'stok_minimum',
        'updated_at',
    ];

    public function kemasan()
    {
        return $this->belongsTo(Kemasan::class, 'id_kemasan', 'id_kemasan');
    }
}
