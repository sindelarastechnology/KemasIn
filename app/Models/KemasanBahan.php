<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KemasanBahan extends Model
{
    protected $table = 'tbl_kemasan_bahan';
    protected $primaryKey = 'id_kemasan_bahan';
    public $timestamps = false;

    protected $fillable = [
        'id_kemasan',
        'id_bahan',
        'jumlah_per_unit',
    ];

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan', 'id_bahan');
    }

    public function kemasan()
    {
        return $this->belongsTo(Kemasan::class, 'id_kemasan', 'id_kemasan');
    }
}
