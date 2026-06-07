<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'tbl_produk';
    protected $primaryKey = 'id_produk';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'nama_produk',
        'stok_tersedia',
        'stok_sudah_dikemas',
        'stok_minimum',
        'harga_produk',
        'keterangan',
    ];

    public function pengemasan()
    {
        return $this->hasMany(Pengemasan::class, 'id_produk', 'id_produk');
    }
}
