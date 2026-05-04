<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_kabupaten extends Model
{
    protected $table = 'kabupaten';
    protected $primaryKey = 'id_kabupaten';

    protected $fillable = ['kode', 'nama_kabupaten', 'provinsi_id'];

    public function provinsi()
    {
        return $this->belongsTo(m_provinsi::class, 'provinsi_id', 'id_provinsi');
    }

    public function kecamatans()
    {
        return $this->hasMany(m_kecamatan::class, 'kabupaten_id', 'id_kabupaten');
    }
}
