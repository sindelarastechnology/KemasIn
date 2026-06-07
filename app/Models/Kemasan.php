<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kemasan extends Model
{
    use HasFactory;
    protected $table = 'tbl_kemasan';
    protected $primaryKey = 'id_kemasan';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'nama_kemasan',
        'ukuran',
        'harga_kemasan',
    ];

    public function pengemasan()
    {
        return $this->hasMany(Pengemasan::class, 'id_kemasan', 'id_kemasan');
    }

    public function stokProduk()
    {
        return $this->hasMany(StokProduk::class, 'id_kemasan', 'id_kemasan');
    }

    public function bahan()
    {
        return $this->hasMany(KemasanBahan::class, 'id_kemasan', 'id_kemasan');
    }
}
