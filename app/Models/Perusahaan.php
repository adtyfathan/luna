<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\FollowerPerusahaan;
use App\Models\Jabatan;
use App\Models\Pengalaman;
use App\Models\Post;
use App\Models\Produk;

class Perusahaan extends Model
{
    protected $table = 'perusahaan';

    protected $fillable = [
        'nama_perusahaan',
        'keterangan',
        'logo',
        'headline',
        'provinsi_id',
        'kota_id'
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }

    public function followerPerusahaan()
    {
        return $this->hasMany(FollowerPerusahaan::class, 'perusahaan_id');
    }

    public function followingPerusahaan()
    {
        return $this->belongsTo(FollowerPerusahaan::class, 'user_id');
    }

    public function jabatan()
    {
        return $this->hasMany(Jabatan::class, 'perusahaan_id');
    }

    public function pengalaman()
    {
        return $this->hasMany(Pengalaman::class, 'perusahaan_id');
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'author');
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'perusahaan_id');
    }
}