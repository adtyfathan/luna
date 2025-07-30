<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pendidikan;

class InstitusiPendidikan extends Model
{
    protected $table = 'institusi_pendidikan';

    protected $fillable = [
        'nama_institusi',
        'logo'
    ];

    public function pendidikan()
    {
        return $this->hasMany(Pendidikan::class, 'institusi_pendidikan_id');
    }
}