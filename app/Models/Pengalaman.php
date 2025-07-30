<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Perusahaan;

class Pengalaman extends Model
{
    protected $table = 'pengalaman';

    protected $fillable = [
        'nama_perusahaan',
        'jabatan',
        'tipe_pekerjaan',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
        'lokasi',
        'user_id',
        'perusahaan_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }
}