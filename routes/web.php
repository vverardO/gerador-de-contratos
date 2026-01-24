<?php

use Illuminate\Support\Facades\Route;

/**
 * remover quando tiver algo pra largar no welcome, assim da
 * pra redirecionar para a /dashboard e no logout para o /
 */
Route::redirect('/', '/acessar');

Route::middleware('guest')->group(function () {
    Route::livewire('/acessar', 'pages::guest.login')->name('login');
    Route::livewire('/registrar', 'pages::guest.register')->name('register');
});

Route::middleware('auth')->group(function () {
    Route::livewire('/', 'pages::auth.dashboard')->name('dashboard');
});
