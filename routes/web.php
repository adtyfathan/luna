<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;
use App\Livewire\Perusahaan\CreatePerusahaan;
use App\Livewire\Perusahaan\EditPerusahaan;
use App\Livewire\Perusahaan\PerusahaanIndex;
use App\Livewire\Edukasi;
use App\Livewire\Materi;
// Pengalaman
use App\Livewire\Pengalaman\Create as CreatePengalaman;
use App\Livewire\Pengalaman\Edit as EditPengalaman;


Route::get('/', Beranda::class)->name('beranda');
Route::get('/edukasi', Edukasi::class)->name('edukasi');
Route::get('/edukasi/{materiId}', Materi::class)->name('materi');

Route::middleware(['auth'])->group(function(){
    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');

    Route::prefix('/pengalaman')->name('pengalaman')->group(function () {
        Route::get('/create', CreatePengalaman::class)->name('.create');
        Route::get('/edit/{pengalamanId}', EditPengalaman::class)->name('.edit');
    });

    Route::prefix('/perusahaan')->name('perusahaan')->group(function () {
        Route::get('/create', CreatePerusahaan::class)->name('.create');
        Route::get('/edit/{perusahaanId}', EditPerusahaan::class)->name('.edit');
        Route::get('/index/{perusahaanId}', PerusahaanIndex::class)->name('.index');
    });
});

require __DIR__.'/auth.php';