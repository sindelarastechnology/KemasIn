<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengemasan extends Model
{
    protected $table = 'tbl_pengemasan';
    protected $primaryKey = 'id_pengemasan';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'id_produk',
        'id_produksi',
        'id_kemasan',
        'tgl_pengemasan',
        'target_jumlah',
        'hasil_pengemasan',
        'expired_date',
        'id_pengguna',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tgl_pengemasan' => 'date',
            'expired_date' => 'date',
        ];
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function kemasan()
    {
        return $this->belongsTo(Kemasan::class, 'id_kemasan', 'id_kemasan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function operatorDitugaskan()
    {
        return $this->belongsToMany(Pengguna::class, 'tbl_pengemasan_operator', 'id_pengemasan', 'id_pengguna');
    }

    public function progresPengemasan()
    {
        return $this->hasMany(ProgresPengemasan::class, 'id_pengemasan', 'id_pengemasan');
    }

    public function pengemasanBahan()
    {
        return $this->hasMany(PengemasanBahan::class, 'id_pengemasan', 'id_pengemasan');
    }
}
