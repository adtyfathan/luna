<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Perusahaan;

class Provinsi extends Model
{
    protected $table = 'provinsi';

    protected $fillable = [
        'nama_provinsi'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'provinsi_id');
    }

    public function perusahaan()
    {
        return $this->hasMany(Perusahaan::class, 'provinsi_id');
    }
}