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

    Route::livewire('/motoristas', 'pages::auth.drivers.index')->name('drivers.index');
    Route::livewire('/motoristas/criar', 'pages::auth.drivers.create')->name('drivers.create');
    Route::livewire('/motoristas/{id}/editar', 'pages::auth.drivers.edit')->name('drivers.edit');

    Route::get('/contrato-app', function () {
        return view('components.templates.app-drive', [
            'motorista_nome' => 'Joao Silva',
            'motorista_documento' => '123.456.789-00',
            'motorista_rua' => 'Rua das Flores',
            'motorista_numero' => '100',
            'motorista_bairro' => 'Centro',
            'motorista_cep' => '97000-000',
            'veiculo' => 'Chevrolet Onix',
            'fabricacao_modelo' => '2023/2024',
            'placa' => 'ABC1D23',
            'chassi' => '9BGKS48B0KG123456',
            'renavam' => '12345678901',
            'proprietario_nome' => 'IZI CAR',
            'proprietario_documento' => '54.379.584/0001-87',
            'valor' => '89,90',
            'valor_extenso' => 'oitenta e nove reais e noventa centavos',
            'data_hoje' => '24 de janeiro de 2026',
        ]);
    });
});
