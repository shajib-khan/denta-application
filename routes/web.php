<?php

use App\Livewire\Doctor\DoctorAll;
use App\Livewire\Home\Index;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
//custom route
//Route::get('/',Index::class)->name('home.index');
Route::get('all-doctor',DoctorAll::class)->name('doctorAll');
