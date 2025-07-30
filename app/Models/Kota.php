<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Perusahaan;

class Kota extends Model
{
    protected $table = 'kota';

    protected $fillable = [
        'nama_kota'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'kota_id');
    }

    public function perusahaan()
    {
        return $this->hasMany(Perusahaan::class, 'kota_id');
    }
}