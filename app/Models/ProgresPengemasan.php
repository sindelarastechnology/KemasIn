<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresPengemasan extends Model
{
    protected $table = 'tbl_pengemasan_progres';
    protected $primaryKey = 'id_progres';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_pengemasan',
        'id_pengguna',
        'jumlah_dikemas',
        'keterangan',
        'waktu_diproses',
    ];

    public function pengemasan()
    {
        return $this->belongsTo(Pengemasan::class, 'id_pengemasan', 'id_pengemasan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
