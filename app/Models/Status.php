<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Jabatan;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = [
        'status'
    ];

    public function jabatan()
    {
        return $this->hasMany(Jabatan::class, 'status_id');
    }
}