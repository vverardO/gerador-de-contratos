<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return $this->redirect(route('login'), navigate: true);
    }
}
?>

<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <nav class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center h-auto sm:h-16 py-3 sm:py-0 gap-3 sm:gap-0">
                <div class="flex items-center">
                    <span class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">{{ config('app.name') }}</span>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 w-full sm:w-auto">
                    <span class="text-sm sm:text-base text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                    @include('components.theme-switcher')
                    <button
                        wire:click="logout"
                        class="w-full sm:w-auto px-4 py-2 text-sm sm:text-base bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                    >
                        Sair
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 mb-4 sm:mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3 sm:mb-4">Painel</h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-4 sm:mb-6">Bem-vindo ao seu painel, {{ auth()->user()->name }}!</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            <a href="{{ route('contractTemplates.index') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer" wire:navigate>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Templates de Contrato</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Gerenciar templates de contrato</p>
                    </div>
                    <i class="fas fa-file-alt text-blue-600 dark:text-blue-400 text-3xl"></i>
                </div>
            </a>
            <a href="{{ route('contracts.index') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer" wire:navigate>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Contratos</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Gerenciar contratos</p>
                    </div>
                    <i class="fas fa-file-contract text-blue-600 dark:text-blue-400 text-3xl"></i>
                </div>
            </a>
            <a href="{{ route('drivers.index') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer" wire:navigate>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Motoristas</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Gerenciar motoristas</p>
                    </div>
                    <i class="fas fa-users text-blue-600 dark:text-blue-400 text-3xl"></i>
                </div>
            </a>
            <a href="{{ route('vehicles.index') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer" wire:navigate>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Veículos</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Gerenciar veículos</p>
                    </div>
                    <i class="fas fa-car text-blue-600 dark:text-blue-400 text-3xl"></i>
                </div>
            </a>
            <a href="{{ route('vehicleOwners.index') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer" wire:navigate>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Proprietários</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Gerenciar proprietários</p>
                    </div>
                    <i class="fas fa-user-tie text-blue-600 dark:text-blue-400 text-3xl"></i>
                </div>
            </a>
            <a href="{{ route('vehicleBrands.index') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer" wire:navigate>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Marcas de Veículos</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Gerenciar marcas de veículos</p>
                    </div>
                    <i class="fas fa-tags text-blue-600 dark:text-blue-400 text-3xl"></i>
                </div>
            </a>
            <a href="{{ route('vehicleModels.index') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer" wire:navigate>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Modelos de Veículos</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Gerenciar modelos de veículos</p>
                    </div>
                    <i class="fas fa-car-side text-blue-600 dark:text-blue-400 text-3xl"></i>
                </div>
            </a>
        </div>
    </main>
</div>
