<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Pengguna extends Authenticatable
{
    use HasFactory;

    protected $table = 'tbl_pengguna';
    protected $primaryKey = 'id_pengguna';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'id_pengguna';
    }

    public function progresPengemasan()
    {
        return $this->hasMany(ProgresPengemasan::class, 'id_pengguna', 'id_pengguna');
    }

    public function pengemasan()
    {
        return $this->hasMany(Pengemasan::class, 'id_pengguna', 'id_pengguna');
    }

}
