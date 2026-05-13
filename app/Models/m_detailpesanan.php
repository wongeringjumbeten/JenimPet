<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_detailpesanan extends Model
{
    protected $table = 'detailpesanan';
    protected $primaryKey = 'id_detailpesanan';
    public $timestamps = true;

    protected $fillable = [
        'pesanan_id',
        'produk_id',
        'kuantitas_pembelian',
        'harga_satuan'
    ];

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->belongsTo(m_pesanan::class, 'pesanan_id', 'id_pesanan');
    }

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(m_produk::class, 'produk_id', 'id_produk');
    }

    // Accessor buat subtotal
    public function getSubtotalAttribute()
    {
        return $this->kuantitas_pembelian * $this->harga_satuan;
    }

    // Accessor buat nama produk
    public function getNamaProdukAttribute()
    {
        return $this->produk->nama_produk ?? 'Produk tidak ditemukan';
    }
}
