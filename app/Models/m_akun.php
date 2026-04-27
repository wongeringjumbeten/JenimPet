<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // ← PASTIKAN INI
use Illuminate\Notifications\Notifiable;

class m_akun extends Authenticatable // ← EXTENDS Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'akun';
    protected $primaryKey = 'id_akun';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'no_telp',
        'alamat',
        'is_admin',
        'google_id',
        'google_token',
        'google_refresh_token',
        'avatar',
        'kecamatan_id',
    ];

    protected $hidden = [
        'password',
        'google_token',
        'google_refresh_token',
    ];
    public function getAuthIdentifierName()
    {
    return 'id_akun';
    }
    protected $casts = [
    'is_admin' => 'boolean',
    ];
}

