<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_produk extends Model
{
    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'foto_produk',
        'is_deleted'
    ];

    public $timestamps = true;
}
