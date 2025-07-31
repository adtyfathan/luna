<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;

// Pengalaman
use App\Livewire\Pengalaman\Create as CreatePengalaman;
use App\Livewire\Pengalaman\Edit as EditPengalaman;


Route::get('/', Beranda::class)->name('beranda');

Route::middleware(['auth'])->group(function(){
    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');

    Route::prefix('/pengalaman')->name('pengalaman')->group(function () {
        Route::get('/create', CreatePengalaman::class)->name('.create');
        Route::get('/edit/{pengalamanId}', EditPengalaman::class)->name('.edit');
    });
});

require __DIR__.'/auth.php';