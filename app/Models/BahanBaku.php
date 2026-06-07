<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;
    protected $table = 'tbl_bahan_baku';
    protected $primaryKey = 'id_bahan';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'nama_bahan',
        'satuan',
        'stok_tersedia',
        'stok_minimum',
        'harga_per_satuan',
        'keterangan',
    ];
}
