<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;

// Pengalaman
use App\Livewire\Pengalaman\Create as CreatePengalaman;
use App\Livewire\Pengalaman\Edit as EditPengalaman;

// Pendidikan
use App\Livewire\Pendidikan\Create as CreatePendidikan;
use App\Livewire\Pendidikan\Edit as EditPendidikan;

// Post
use App\Livewire\Post\Create as CreatePost;
use App\Livewire\Post\Edit as EditPost;

use App\Livewire\Pengguna;

use App\Livewire\Koneksi;

Route::get('/', Beranda::class)->name('beranda');

Route::middleware(['auth'])->group(function(){
    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');

    Route::prefix('/pengalaman')->name('pengalaman')->group(function () {
        Route::get('/create', CreatePengalaman::class)->name('.create');
        Route::get('/edit/{pengalamanId}', EditPengalaman::class)->name('.edit');
    });

    Route::prefix('/pendidikan')->name('pendidikan')->group(function () {
        Route::get('/create', CreatePendidikan::class)->name('.create');
        Route::get('/edit/{pendidikanId}', EditPendidikan::class)->name('.edit');
    });

    Route::prefix('/post')->name('post')->group(function () {
        Route::get('/create', CreatePost::class)->name('.create');
        Route::get('/edit/{postId}', EditPost::class)->name('.edit');
    });

    Route::get('/pengguna/{userId}', Pengguna::class)->name('pengguna');

    Route::get('/koneksi', Koneksi::class)->name('koneksi');
});

require __DIR__.'/auth.php';