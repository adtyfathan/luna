<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Follow extends Model
{
    protected $table = 'follow';

    protected $fillable = [
        'follower_id',
        'following_id'
    ];

    public function follower(){
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function following(){
        return $this->belongsTo(User::class, 'following_id');
    }
}