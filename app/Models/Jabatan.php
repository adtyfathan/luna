<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Perusahaan;
use App\Models\Status;

class Jabatan extends Model
{
    protected $table = 'jabatan';

    protected $fillable = [
        'user_id',
        'perusahaan_id',
        'status_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}