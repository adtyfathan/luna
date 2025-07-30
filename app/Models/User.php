<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Follow;
use App\Models\FollowerPerusahaan;
use App\Models\Jabatan;
use App\Models\Pengalaman;
use App\Models\Pendidikan;
use App\Models\Post;
use App\Models\Like;
use App\Models\Komentar;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto_profil',
        'headline',
        'keterangan',
        'provinsi_id',
        'kota_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }

    public function follower()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function following()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    public function followerPerusahaan()
    {
        return $this->hasMany(FollowerPerusahaan::class, 'follower_id');
    }

    public function jabatan()
    {
        return $this->hasMany(Jabatan::class, 'user_id');
    }

    public function pengalaman()
    {
        return $this->hasMany(Pengalaman::class, 'user_id');
    }

    public function pendidikan()
    {
        return $this->hasMany(Pendidikan::class, 'user_id');
    }

    // Polymorphic
    public function posts()
    {
        return $this->morphMany(Post::class, 'author');
    }

    public function like()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'user_id');
    }
}