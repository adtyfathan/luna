<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\InstitusiPendidikan;

class Pendidikan extends Model
{
    protected $table = 'pendidikan';

    protected $fillable = [
        'nama_institusi',
        'tingkat',
        'jurusan',
        'tanggal_mulai',
        'tanggal_selesai',
        'ipk',
        'deskripsi',
        'user_id',
        'institusi_pendidikan_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function institusiPendidikan()
    {
        return $this->belongsTo(InstitusiPendidikan::class, 'institusi_pendidikan_id');
    }
}