<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;

Route::get('/', Beranda::class)->name('beranda');

Route::middleware(['auth'])->group(function(){
    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');
});

require __DIR__.'/auth.php';