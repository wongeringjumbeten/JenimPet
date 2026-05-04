<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class m_akun extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'akun';
    protected $primaryKey = 'id_akun';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'no_telp',
        'alamat',             // Sementara masih dipakai (nanti bisa dihapus)
        'detail_alamat',      // Tambahin ini!
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

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    public function getAuthIdentifierName()
    {
        return 'id_akun';
    }

    // =====================
    // RELASI KE KECAMATAN
    // =====================
    public function kecamatan()
    {
        return $this->belongsTo(M_Kecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }

    // =====================
    // ACCESSOR: FULL ALAMAT LENGKAP
    // =====================
    public function getFullAlamatAttribute()
    {
        // Kalau ada relasi kecamatan, ambil dari situ
        if ($this->kecamatan && $this->kecamatan->kabupaten && $this->kecamatan->kabupaten->provinsi) {
            $kec = $this->kecamatan;
            $kab = $kec->kabupaten;
            $prov = $kab->provinsi;

            $detail = $this->detail_alamat ? $this->detail_alamat . ', ' : '';
            return $detail . $kec->nama_kecamatan . ', ' . $kab->nama_kabupaten . ', ' . $prov->nama_provinsi;
        }

        // Fallback: kalau belum pake kecamatan_id, pakai kolom alamat lama
        return $this->alamat;
    }

    // =====================
    // ACCESSOR: NAMA LENGKAP WILAYAH (tanpa detail alamat)
    // =====================
    public function getWilayahAttribute()
    {
        if ($this->kecamatan && $this->kecamatan->kabupaten && $this->kecamatan->kabupaten->provinsi) {
            $kec = $this->kecamatan;
            $kab = $kec->kabupaten;
            $prov = $kab->provinsi;

            return $prov->nama_provinsi . ', ' . $kab->nama_kabupaten . ', ' . $kec->nama_kecamatan;
        }

        return $this->alamat;
    }

    // =====================
    // MUTATOR: SIMPAN ALAMAT DARI FORM
    // =====================
    public function setAlamatFromDropdown($provinsi, $kabupaten, $kecamatan, $detail = null)
    {
        // Cari ID kecamatan berdasarkan nama (nanti bisa pakai API/dropdown)
        // Sementara isi manual dulu

        $this->detail_alamat = $detail;
        // $this->kecamatan_id = ... nanti diisi dari dropdown

        // Backup ke kolom alamat lama (biar kompatibel)
        $this->alamat = $provinsi . ', ' . $kabupaten . ', ' . $kecamatan;
    }
}
