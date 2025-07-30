<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class GambarPost extends Model
{
    protected $table = 'gambar_post';

    protected $fillable = [
        'url',
        'post_id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}