<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Perusahaan;

class FollowerPerusahaan extends Model
{
    protected $table = 'follower_perusahaan';

    protected $fillable = [
        'follower_id',
        'perusahaan_id'
    ];

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');    
    }
}