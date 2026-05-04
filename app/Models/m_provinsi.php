<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_provinsi extends Model
{
    protected $table = 'provinsi';
    protected $primaryKey = 'id_provinsi';

    protected $fillable = ['kode', 'nama_provinsi'];

    public function kabupatens()
    {
        return $this->hasMany(m_kabupaten::class, 'provinsi_id', 'id_provinsi');
    }
}
