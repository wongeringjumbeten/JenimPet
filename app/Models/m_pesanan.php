<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = true;

    protected $fillable = [
        'akun_id',
        'tanggal_pesanan',
        'total_pembayaran',
        'status_pesanan',
        'nomor_resi',
        'catatan',
        'alamat',
        'metode_pembayaran',
        'bukti_pembayaran'
    ];

    protected $casts = [
        'tanggal_pesanan' => 'datetime',
        'total_pembayaran' => 'integer',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(m_akun::class, 'akun_id', 'id_akun');
    }

    // Relasi ke detail pesanan
    public function detail()
    {
        return $this->hasMany(m_detailpesanan::class, 'pesanan_id', 'id_pesanan');
    }

    // Helper label status
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pengecekan pembayaran' => ['label' => 'validasi Pembayaran', 'color' => 'bg-yellow-500'],
            'diproses' => ['label' => 'Diproses', 'color' => 'bg-blue-500'],
            'diantar' => ['label' => 'Diantar', 'color' => 'bg-indigo-500'],
            'ditolak' => ['label' => 'Ditolak', 'color' => 'bg-red-500'],
            'selesai' => ['label' => 'Selesai', 'color' => 'bg-green-500'],
        ];
        return $labels[$this->status_pesanan] ?? ['label' => $this->status_pesanan, 'color' => 'bg-gray-500'];
    }

    // Helper metode pembayaran
    public function getMetodePembayaranLabelAttribute()
    {
        $metode = [
            'transfer_bca' => 'Transfer BCA',
            'transfer_mandiri' => 'Transfer Mandiri',
            'e_wallet' => 'E-Wallet (OVO/GoPay/DANA)',
        ];
        return $metode[$this->metode_pembayaran] ?? $this->metode_pembayaran;
    }
}
