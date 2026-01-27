<?php

use App\Http\Controllers\ContractController;
use Illuminate\Support\Facades\Route;

/**
 * remover quando tiver algo pra largar no welcome, assim da
 * pra redirecionar para a /dashboard e no logout para o /
 */
Route::redirect('/', '/acessar');

Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');

Route::middleware('guest')->group(function () {
    Route::livewire('/acessar', 'pages::guest.login')->name('login');
    Route::livewire('/registrar', 'pages::guest.register')->name('register');
});

Route::middleware('auth')->group(function () {
    Route::livewire('/', 'pages::auth.dashboard')->name('dashboard');

    Route::livewire('/motoristas', 'pages::auth.drivers.index')->name('drivers.index');
    Route::livewire('/motoristas/criar', 'pages::auth.drivers.create')->name('drivers.create');
    Route::livewire('/motoristas/{id}/editar', 'pages::auth.drivers.edit')->name('drivers.edit');

    Route::livewire('/proprietarios', 'pages::auth.vehicle-owners.index')->name('vehicleOwners.index');
    Route::livewire('/proprietarios/criar', 'pages::auth.vehicle-owners.create')->name('vehicleOwners.create');
    Route::livewire('/proprietarios/{id}/editar', 'pages::auth.vehicle-owners.edit')->name('vehicleOwners.edit');

    Route::livewire('/veiculos', 'pages::auth.vehicles.index')->name('vehicles.index');
    Route::livewire('/veiculos/criar', 'pages::auth.vehicles.create')->name('vehicles.create');
    Route::livewire('/veiculos/{id}/editar', 'pages::auth.vehicles.edit')->name('vehicles.edit');

    Route::livewire('/contratos', 'pages::auth.contracts.index')->name('contracts.index');
    Route::livewire('/contratos/criar', 'pages::auth.contracts.create')->name('contracts.create');
    Route::livewire('/contratos/{id}/editar', 'pages::auth.contracts.edit')->name('contracts.edit');

    Route::get('/contratos/{id}/visualizar', [ContractController::class, 'show'])->name('contracts.show');
});
