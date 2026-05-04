<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $primaryKey = 'id_kecamatan';

    protected $fillable = ['kode', 'nama_kecamatan', 'kabupaten_id'];

    public function kabupaten()
    {
        return $this->belongsTo(m_kabupaten::class, 'kabupaten_id', 'id_kabupaten');
    }

    public function akuns()
    {
        return $this->hasMany(m_akun::class, 'kecamatan_id', 'id_kecamatan');
    }
}
