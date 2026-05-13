<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    public $timestamps = true;

    protected $fillable = [
        'kuantitas',
        'is_selected',
        'akun_id_akun',
        'produk_id_produk'
    ];

    protected $casts = [
        'is_selected' => 'string', // karena CHAR(1) default '0'
    ];

    // Relasi ke user (akun)
    public function user()
    {
        return $this->belongsTo(m_akun::class, 'akun_id_akun', 'id_akun');
    }

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(m_produk::class, 'produk_id_produk', 'id_produk');
    }

    // Helper: cek apakah item dipilih untuk checkout
    public function isSelected()
    {
        return $this->is_selected === '1';
    }
}
