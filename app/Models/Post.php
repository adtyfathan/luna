<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GambarPost;
use App\Models\Like;
use App\Models\Komentar;

class Post extends Model
{
    protected $table = 'post';

    protected $fillable = [
        'konten',
        'author_type',
        'author_id'
    ];

    // Polymorphic
    public function author()
    {
        return $this->morphTo();
    }

    public function gambarPost()
    {
        return $this->hasMany(GambarPost::class, 'post_id');
    }

    public function like()
    {
        return $this->hasMany(Like::class, 'post_id');
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'post_id');
    }
}