<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengemasanOperator extends Model
{
    protected $table = 'tbl_pengemasan_operator';
    protected $primaryKey = 'id_pengemasan_operator';
    public $timestamps = false;

    protected $fillable = [
        'id_pengemasan',
        'id_pengguna',
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
